<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OpenAIChat
{
    private string $apiKey;
    private string $model;
    private int    $maxTokens;
    private float  $temperature;
    private string $systemPrompt;

    public function __construct()
    {
        $this->apiKey      = config('openai.api_key', '');
        $this->model       = config('openai.model', 'gpt-4o-mini');
        $this->maxTokens   = (int) config('openai.max_tokens', 450);
        $this->temperature = (float) config('openai.temperature', 0.7);
        $this->systemPrompt = config('openai.system_prompt', '');
    }

    /**
     * Build the messages array from session history + new user message.
     */
    public function buildMessages(array $history, string $userMessage): array
    {
        $messages = [['role' => 'system', 'content' => $this->systemPrompt]];

        foreach ($history as $msg) {
            if (isset($msg['role'], $msg['content'])) {
                $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        return $messages;
    }

    /**
     * Blocking call — returns ['reply', 'usage', 'error'].
     */
    public function send(array $messages): array
    {
        $payload = [
            'model'       => $this->model,
            'messages'    => $messages,
            'max_tokens'  => $this->maxTokens,
            'temperature' => $this->temperature,
            'store'       => true,
        ];

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => !app()->environment('local'),
            CURLOPT_SSL_VERIFYHOST => app()->environment('local') ? 0 : 2,
        ]);

        $response = curl_exec($ch);
        $curlErr  = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$response || $curlErr) {
            return ['reply' => '', 'usage' => [], 'error' => 'RC-CHAT-003'];
        }

        $data = json_decode($response, true);

        if ($httpCode >= 400 || isset($data['error'])) {
            $code = ($httpCode >= 500 || $httpCode === 429) ? 'RC-CHAT-005' : 'RC-CHAT-004';
            Log::error('[OpenAIChat] API error', ['http' => $httpCode, 'body' => $data]);
            return ['reply' => '', 'usage' => [], 'error' => $code];
        }

        $reply = $data['choices'][0]['message']['content'] ?? '';
        $usage = [
            'in'    => (int) ($data['usage']['prompt_tokens']     ?? 0),
            'out'   => (int) ($data['usage']['completion_tokens'] ?? 0),
            'total' => (int) ($data['usage']['total_tokens']      ?? 0),
        ];

        if (!$reply) {
            return ['reply' => '', 'usage' => $usage, 'error' => 'RC-CHAT-006'];
        }

        $reply = $this->cleanReply($reply);

        return ['reply' => $reply, 'usage' => $usage, 'error' => null];
    }

    /**
     * Streaming call — emits SSE frames directly to the response buffer.
     * Returns ['reply', 'usage', 'error'] after stream completes.
     */
    public function stream(array $messages): array
    {
        $payload = [
            'model'          => $this->model,
            'messages'       => $messages,
            'max_tokens'     => $this->maxTokens,
            'temperature'    => $this->temperature,
            'stream'         => true,
            'stream_options' => ['include_usage' => true],
            'store'          => true,
        ];

        $this->sseSend('start', ['ok' => true]);
        // Padding comment: some proxies buffer until ~2KB before flushing
        echo ':' . str_repeat(' ', 2048) . "\n\n";
        @ob_flush(); @flush();

        $assembled = '';
        $usage     = ['in' => 0, 'out' => 0, 'total' => 0];
        $buffer    = '';

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
                'Accept: text/event-stream',
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => !app()->environment('local'),
            CURLOPT_SSL_VERIFYHOST => app()->environment('local') ? 0 : 2,
            CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) use (&$assembled, &$usage, &$buffer) {
                $buffer .= $chunk;
                while (($pos = strpos($buffer, "\n")) !== false) {
                    $line   = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 1);
                    $line   = trim($line);
                    if ($line === '' || strpos($line, 'data:') !== 0) continue;
                    $data = trim(substr($line, 5));
                    if ($data === '[DONE]') continue;
                    $obj = json_decode($data, true);
                    if (!is_array($obj)) continue;

                    if (isset($obj['usage']) && is_array($obj['usage'])) {
                        $usage = [
                            'in'    => (int) ($obj['usage']['prompt_tokens']     ?? 0),
                            'out'   => (int) ($obj['usage']['completion_tokens'] ?? 0),
                            'total' => (int) ($obj['usage']['total_tokens']      ?? 0),
                        ];
                        $this->sseSend('usage', $usage);
                        continue;
                    }

                    $delta = $obj['choices'][0]['delta']['content'] ?? '';
                    if ($delta !== '') {
                        $assembled .= $delta;
                        $this->sseSend('delta', ['v' => $delta]);
                    }
                }
                return strlen($chunk);
            },
        ]);

        $ok       = curl_exec($ch);
        $curlErr  = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$ok || $curlErr) {
            $this->sseSend('error', ['code' => 'RC-CHAT-003', 'reply' => $this->userMsg('RC-CHAT-003')]);
            return ['reply' => '', 'usage' => $usage, 'error' => 'RC-CHAT-003'];
        }

        if ($httpCode >= 400) {
            $code = ($httpCode >= 500 || $httpCode === 429) ? 'RC-CHAT-005' : 'RC-CHAT-004';
            $this->sseSend('error', ['code' => $code, 'reply' => $this->userMsg($code)]);
            return ['reply' => '', 'usage' => $usage, 'error' => $code];
        }

        $this->sseSend('done', ['ok' => true]);

        return ['reply' => $assembled, 'usage' => $usage, 'error' => null];
    }

    // -----------------------------------------------------------------------

    public function isIdentityQuestion(string $message): bool
    {
        $lower = strtolower($message);
        return preg_match('/\b(who|what)\s+(are|r)\s+(you|u)\b/i', $lower)
            || preg_match('/\b(are|r)\s+(you|u)\s+(an?\s+)?(ai|chatbot|bot|gpt|gemini)\b/i', $lower);
    }

    public function identityReply(): string
    {
        return config('openai.identity_reply');
    }

    public function userMsg(string $code): string
    {
        $map = [
            'RC-CHAT-001' => 'Please type a message first 😊',
            'RC-CHAT-002' => 'Invalid request.',
            'RC-CHAT-003' => 'Connection issue — please try again in a moment 🙏',
            'RC-CHAT-004' => 'Hmm, something went wrong on our end. Please try again.',
            'RC-CHAT-005' => 'The AI service is temporarily unavailable. Please try again shortly 🔧',
            'RC-CHAT-006' => 'I got an empty response — please try rephrasing your question 🤔',
            'RC-RATE-001' => "You've sent a lot of messages this hour! Please wait a few minutes before trying again ⏳",
            'RC-RATE-002' => "You've reached today's message limit. Please come back tomorrow 🌅",
            'RC-RATE-003' => "You've used a lot of tokens today! Please come back tomorrow 🔋",
        ];
        return $map[$code] ?? 'Something went wrong. Please try again.';
    }

    private function cleanReply(string $reply): string
    {
        $reply = preg_replace('/(<\/?s>|\[\/?\s*OUT\]|\[IN\]|<PAD>)/i', '', trim($reply));
        if (strlen($reply) > 600) {
            $short = substr($reply, 0, 600);
            $short = preg_replace('/\s+?[^.?!]*$/', '', $short);
            $reply = $short . '...';
        }
        return $reply;
    }

    private function sseSend(string $event, array $data): void
    {
        echo "event: $event\n";
        echo 'data: ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n\n";
        @ob_flush(); @flush();
    }
}
