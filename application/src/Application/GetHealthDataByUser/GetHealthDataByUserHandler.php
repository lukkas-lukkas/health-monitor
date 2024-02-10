<?php declare(strict_types=1);

namespace HealthMonitor\Application\GetHealthDataByUser;

use HealthMonitor\Domain\HealthDataRepository;

class GetHealthDataByUserHandler
{
    public function __construct(private HealthDataRepository $repository)
    {
    }

    public function handle(string $userID): array
    {
        $list = $this->repository->getByUser($userID);

        return array_map(fn ($item) => $item->toArray(), $list);
    }
}
