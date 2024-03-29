<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

use HealthMonitor\Domain\DuplicatedResourceException;
use HealthMonitor\Domain\HealthData;
use HealthMonitor\Domain\HealthDataRepository;
use HealthMonitor\Domain\IdGenerator;

class StoreHealthDataHandler
{
    public function __construct(
        private IdGenerator $idGenerator,
        private HealthDataRepository $repository,
        private Producer $producer,
    ) {
    }

    /**
     * @throws DuplicatedResourceException
     */
    public function handle(HealthDataDTO $dto): HealthData
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

        $this->repository->store($hd);

        $this->producer->produce($hd);

        return $hd;
    }
}
