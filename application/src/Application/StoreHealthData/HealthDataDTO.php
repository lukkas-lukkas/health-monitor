<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

use DateTime;
use DateTimeInterface;

readonly class HealthDataDTO
{
    public function __construct(
        public string $userID,
        public DateTimeInterface $startedAt,
        public DateTimeInterface $finishedAt,
        public int $avgBpm,
        public int $stepsTotal,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            new DateTime($data['started_at']),
            new DateTime($data['finished_at']),
            (int) $data['avg_bpm'],
            (int) $data['steps_total'],
        );
    }
}
