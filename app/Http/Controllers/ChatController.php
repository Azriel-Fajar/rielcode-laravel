<?php

namespace App\Http\Controllers;

use App\Services\AuditLogger;
use App\Services\OpenAIChat;
use App\Services\RateLimiter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    public function __construct(private OpenAIChat $chat) {}

    /**
     * POST /api/chat — blocking JSON response.
     */
    public function send(Request $request): JsonResponse
    {
        $message = trim($request->input('message', ''));
        $source  = trim($request->input('source', ''));
        $ip      = $request->ip();

        if (!$message) {
            return response()->json([
                'ok'    => false,
                'reply' => $this->chat->userMsg('RC-CHAT-001'),
                'code'  => 'RC-CHAT-001',
            ], 400);
        }

        // Identity shortcut — no API call needed
        if ($this->chat->isIdentityQuestion($message)) {
            return response()->json(['ok' => true, 'reply' => $this->chat->identityReply()]);
        }

        $history  = $this->sessionHistory($request);
        $messages = $this->chat->buildMessages($history, $message);

        $result = $this->chat->send($messages);

        if ($result['error']) {
            return response()->json([
                'ok'    => false,
                'reply' => $this->chat->userMsg($result['error']),
                'code'  => $result['error'],
            ], 500);
        }

        $this->storeInSession($request, $message, $result['reply']);

        if ($source === 'chatbot' && !empty($result['usage']['total'])) {
            RateLimiter::addTokens($ip, $result['usage']['total']);
        }

        $this->logChat($message, $result['reply'], $result['usage'], $ip, 'chat');

        return response()->json(['ok' => true, 'reply' => $result['reply']]);
    }

    /**
     * GET /api/chat/stream — SSE streaming response.
     */
    public function stream(Request $request): StreamedResponse
    {
        $message = trim($request->input('message', ''));
        $ip      = $request->ip();

        if (!$message) {
            return $this->sseError('RC-CHAT-001', $this->chat->userMsg('RC-CHAT-001'));
        }

        if ($this->chat->isIdentityQuestion($message)) {
            return new StreamedResponse(function () {
                echo "event: start\ndata: {\"ok\":true}\n\n";
                echo 'event: delta\ndata: ' . json_encode(['v' => $this->chat->identityReply()]) . "\n\n";
                echo "event: done\ndata: {\"ok\":true}\n\n";
                @ob_flush(); @flush();
            }, 200, $this->sseHeaders());
        }

        $history  = $this->sessionHistory($request);
        $messages = $this->chat->buildMessages($history, $message);

        return new StreamedResponse(function () use ($request, $message, $messages, $ip) {
            // Kill output buffering
            while (ob_get_level() > 0) { @ob_end_flush(); }
            @ini_set('zlib.output_compression', '0');

            $result = $this->chat->stream($messages);

            if (!$result['error']) {
                $this->storeInSession($request, $message, $result['reply']);
                RateLimiter::addTokens($ip, $result['usage']['total'] ?? 0);
                $this->logChat($message, $result['reply'], $result['usage'], $ip, 'chat');
            } else {
                $this->logChat($message, '', $result['usage'], $ip, 'error');
            }
        }, 200, $this->sseHeaders());
    }

    // -----------------------------------------------------------------------

    private function sessionHistory(Request $request): array
    {
        $history = $request->session()->get('rielbot_memory', []);
        if (count($history) > 20) {
            $history = array_slice($history, -20);
        }
        return $history;
    }

    private function storeInSession(Request $request, string $userMsg, string $botReply): void
    {
        $history   = $request->session()->get('rielbot_memory', []);
        $history[] = ['role' => 'user',      'content' => $userMsg];
        $history[] = ['role' => 'assistant', 'content' => $botReply];
        if (count($history) > 20) {
            $history = array_slice($history, -20);
        }
        $request->session()->put('rielbot_memory', $history);
    }

    private function logChat(string $userMsg, string $botReply, array $usage, string $ip, string $tag): void
    {
        try {
            \DB::table('chat_logs')->insert([
                'user_message'  => $userMsg,
                'bot_reply'     => $botReply,
                'ip_address'    => $ip,
                'input_tokens'  => $usage['in']  ?? null,
                'output_tokens' => $usage['out'] ?? null,
                'tag'           => $tag,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        } catch (\Throwable $e) {
            AuditLogger::log('CHAT_LOG_INSERT_FAIL', 'error', $ip, ['err' => $e->getMessage()]);
        }
    }

    private function sseHeaders(): array
    {
        return [
            'Content-Type'      => 'text/event-stream; charset=utf-8',
            'Cache-Control'     => 'no-cache, no-transform',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ];
    }

    private function sseError(string $code, string $reply): StreamedResponse
    {
        return new StreamedResponse(function () use ($code, $reply) {
            echo "event: error\n";
            echo 'data: ' . json_encode(['code' => $code, 'reply' => $reply]) . "\n\n";
            @ob_flush(); @flush();
        }, 200, $this->sseHeaders());
    }
}
