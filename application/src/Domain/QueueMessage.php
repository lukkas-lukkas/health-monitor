<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

readonly class QueueMessage
{
    public function __construct(
        public Topic $topic,
        public string $key,
        public array $body,
        public array $properties = [],
        public array $headers = [],
    ) {
    }
}
