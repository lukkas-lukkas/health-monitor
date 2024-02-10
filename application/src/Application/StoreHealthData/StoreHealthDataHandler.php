<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

use HealthMonitor\Domain\HealthData;
use HealthMonitor\Domain\IdGenerator;

class StoreHealthDataHandler
{
    public function __construct(
        private IdGenerator $idGenerator,
    ) {
    }

    public function handle(HealthDataDTO $dto): array
    {
        $id = $this->idGenerator->generate($dto->userID, $dto->startedAt, $dto->finishedAt);

        $hd = new HealthData(
            $id,
            $dto->userID,
            $dto->startedAt,
            $dto->finishedAt,
            $dto->avgBpm,
            $dto->stepsTotal,
        );

        return $hd->toArray();
    }
}
