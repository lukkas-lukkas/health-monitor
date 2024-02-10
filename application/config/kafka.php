<?php declare(strict_types=1);

return [
    'global' => [
        'group.id' => uniqid('group_id', true),
        'metadata.broker.list' => env('KAFKA_BROKER'),
        'enable.auto.commit' => 'false',
    ],
    'topic' => [
        'auto.offset.reset' => 'beginning',
    ],
];
