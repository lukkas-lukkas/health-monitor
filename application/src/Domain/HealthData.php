<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

use Carbon\Carbon;
use DateTimeInterface;

class HealthData
{
    private const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function __construct(
        public readonly string $id,
        public readonly string $userID,
        public readonly DateTimeInterface $startedAt,
        public readonly DateTimeInterface $finishedAt,
        public readonly int $avgBpm,
        public readonly int $stepsTotal,
        private ?DateTimeInterface $createdAt = null,
        private ?string $anomalies = null,
    ) {
        if (is_null($this->createdAt)) {
            $this->createdAt = Carbon::now();
        }
    }

    public function setAnomalies(string $anomalies): void
    {
        $this->anomalies = $anomalies;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userID,
            'started_at' => $this->startedAt->format(self::DATE_FORMAT),
            'finished_at' => $this->finishedAt->format(self::DATE_FORMAT),
            'avg_bpm' => $this->avgBpm,
            'steps_total' => $this->stepsTotal,
            'created_at' => $this->createdAt->format(self::DATE_FORMAT),
            'anomalies' => $this->anomalies,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['user_id'],
            Carbon::parse($data['started_at']),
            Carbon::parse($data['finished_at']),
            $data['avg_bpm'],
            $data['steps_total'],
            Carbon::parse($data['created_at']),
            $data['anomalies'],
        );
    }
}
