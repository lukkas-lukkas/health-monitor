<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

use HealthMonitor\Domain\HealthData;

class StoreHealthDataHandler
{
    public function __construct(
        private IdGenerator $idGenerator,
    ) {
    }

    public function handle(HealthDataDTO $dto): array
    {
        $hd = new HealthData(
            $this->idGenerator->generate($dto),
            $dto->userID,
            $dto->startedAt,
            $dto->finishedAt,
            $dto->avgBpm,
            $dto->stepsTotal,
        );

        return $hd->toArray();
    }
}
