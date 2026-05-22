<?php

namespace App\Support;

class ErrorCodes
{
    const ERRORS = [
        'RC-DB-001'    => ['msg' => 'Service temporarily unavailable.',             'http' => 503],
        'RC-DB-002'    => ['msg' => 'Could not save your request.',                 'http' => 500],
        'RC-DB-003'    => ['msg' => 'Record not found.',                            'http' => 404],

        'RC-AUTH-001'  => ['msg' => 'Invalid credentials.',                         'http' => 401],
        'RC-AUTH-002'  => ['msg' => 'Session expired, please log in again.',        'http' => 401],
        'RC-AUTH-003'  => ['msg' => 'Form expired, please reload.',                 'http' => 419],

        'RC-CHAT-001'  => ['msg' => 'Please type a message.',                       'http' => 400],
        'RC-CHAT-002'  => ['msg' => 'RielBot only supports English.',               'http' => 400],
        'RC-CHAT-003'  => ['msg' => 'AI temporarily unreachable.',                  'http' => 502],
        'RC-CHAT-004'  => ['msg' => 'Invalid request to AI.',                       'http' => 400],
        'RC-CHAT-005'  => ['msg' => 'AI service is busy.',                          'http' => 503],
        'RC-CHAT-006'  => ['msg' => 'No response, please retry.',                   'http' => 502],
        'RC-CHAT-007'  => ['msg' => 'Streaming error, falling back.',               'http' => 500],

        'RC-RATE-001'  => ['msg' => "You've hit the hourly chat limit. Try again in an hour.", 'http' => 429],
        'RC-RATE-002'  => ['msg' => 'Daily chat limit reached. Try again tomorrow.',           'http' => 429],
        'RC-RATE-003'  => ['msg' => 'Daily AI usage reached, try tomorrow.',                   'http' => 429],

        'RC-ORDER-001' => ['msg' => 'Order not found.',                             'http' => 404],
        'RC-ORDER-002' => ['msg' => 'Selected package is unavailable.',             'http' => 404],
        'RC-ORDER-003' => ['msg' => 'Order could not be saved.',                    'http' => 500],
        'RC-ORDER-004' => ['msg' => 'Invalid plan selection.',                      'http' => 400],

        'RC-PAY-001'   => ['msg' => 'Invoice could not be generated.',              'http' => 500],
        'RC-PAY-002'   => ['msg' => 'Upload failed, try a smaller image.',          'http' => 400],
        'RC-PAY-003'   => ['msg' => 'Confirmation email could not be sent.',        'http' => 500],

        'RC-ADMIN-001' => ['msg' => 'Forbidden.',                                   'http' => 403],
        'RC-ADMIN-002' => ['msg' => 'Action failed.',                               'http' => 500],
        'RC-ADMIN-003' => ['msg' => 'Could not generate token.',                    'http' => 500],

        'RC-BRIEF-001' => ['msg' => 'Invalid or expired brief link.',               'http' => 404],
        'RC-BRIEF-002' => ['msg' => 'Please fill in all 5 questions.',              'http' => 400],
        'RC-BRIEF-003' => ['msg' => 'Brief could not be sent. Please try again.',   'http' => 500],

        'RC-TOKEN-001' => ['msg' => 'Invalid or expired link.',                     'http' => 403],
        'RC-TOKEN-002' => ['msg' => 'This link has already been used.',             'http' => 403],
        'RC-TOKEN-003' => ['msg' => 'This link has been deactivated.',              'http' => 403],
    ];

    public static function userMsg(string $code): string
    {
        return self::ERRORS[$code]['msg'] ?? 'Something went wrong.';
    }

    public static function httpStatus(string $code): int
    {
        return self::ERRORS[$code]['http'] ?? 500;
    }

    public static function errorResponse(string $code, ?string $detail = null): array
    {
        $entry = self::ERRORS[$code] ?? ['msg' => 'Something went wrong.', 'http' => 500];

        if ($detail !== null && $detail !== '') {
            error_log("[$code] $detail");
        }

        return [
            'ok'    => false,
            'code'  => $code,
            'http'  => $entry['http'],
            'reply' => $entry['msg'] . ' (ref: ' . $code . ')',
        ];
    }
}
