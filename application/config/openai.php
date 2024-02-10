<?php declare(strict_types=1);

return [
    'client' => [
        'base_uri' => env('OPENAI_API_URL'),
        'timeout' => (int) env('OPENAI_API_TIMEOUT'),
    ],
    'credentials' => [
        'token' => env('OPENAI_API_TOKEN'),
    ],
    'model' => env('OPENAI_API_MODEL'),
    'anomalies' => [
        'role' => [
            'role' => 'system',
            'content' => 'You are a doctor and based on a time range, average bit per minute and total steps, analyse and return possible anomalies for a person, and you only responde with a text with 100 characters',
        ],
    ]
];
