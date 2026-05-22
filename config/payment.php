<?php

return [
    'wa_phone'    => env('WA_PHONE', ''),
    'bank_name'   => env('BANK_NAME', ''),
    'bank_number' => env('BANK_ACCOUNT_NUMBER', ''),
    'bank_name_account' => env('BANK_ACCOUNT_NAME', ''),
    'paypal_me'   => env('PAYPAL_ME', ''),
    'intl' => [
        'beneficiary_name'    => env('INTL_BENEFICIARY_NAME', ''),
        'beneficiary_address' => env('INTL_BENEFICIARY_ADDRESS', ''),
        'bank_name'           => env('INTL_BANK_NAME', ''),
        'bank_address'        => env('INTL_BANK_ADDRESS', ''),
        'account_number'      => env('INTL_ACCOUNT_NUMBER', ''),
        'swift_code'          => env('INTL_SWIFT_CODE', ''),
        'intermediary_bank'   => env('INTL_INTERMEDIARY_BANK', ''),
        'intermediary_swift'  => env('INTL_INTERMEDIARY_SWIFT', ''),
    ],
];
