<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'meta' => [
        'pixel_id' => env('META_PIXEL_ID', '1057716843499038'),
        'capi_token' => env('META_CAPI_TOKEN', 'EAATP3pNl4QgBSFPC0OmvbnQZCAa8d68FZA42rdlFERXuArRRENkMigCXqLBaW4KyfgUxyTUvJhP1buIXEJwfkKVMttfQwGttGNQ0BH26rq4RaRECTciFSmpljQ4t2rwozJloPUHzVgFJ0YLTQZCZAicyaXzoGW5IWDFufNwUZBKWIxWEshYMKOI5JalLV9lv53QZDZD'),
    ],

    'tiktok' => [
        'pixel_id' => env('TIKTOK_PIXEL_ID', 'DA62NE3C77UC8FLJ30EG'),
        'capi_token' => env('TIKTOK_CAPI_TOKEN', '70b2255b67cb35242f1a8b8957093fc7c2d45d57'),
    ],

    'snapchat' => [
        'pixel_id' => env('SNAPCHAT_PIXEL_ID', '84c3351e-4d60-430d-9c66-dc0cf889ed32'),
        'capi_token' => env('SNAPCHAT_CAPI_TOKEN', 'eyJhbGciOiJIUzI1NiIsImtpZCI6IkNhbnZhc1MyU0hNQUNQcm9kIiwidHlwIjoiSldUIn0.eyJhdWQiOiJjYW52YXMtY2FudmFzYXBpIiwiaXNzIjoiY2FudmFzLXMyc3Rva2VuIiwibmJmIjoxNzg1MDUzOTk4LCJzdWIiOiJiYjJkODk1MC01NzkxLTRkNjMtYmNiNy0zMWFiOTUwMWM4ODR-UFJPRFVDVElPTn5mMzdlYjNiNy02NmEzLTRlYmYtYTA0MS1iM2E1NzY0ZmMwMzEifQ.AWz_v84D0bwDGhbS6wKh_5xxD4oZIl2tXxsGxHT0ebs'),
    ],

    'gtm' => [
        'id' => env('GTM_ID', 'GTM-55MZCJ7Z'),
    ],

];
