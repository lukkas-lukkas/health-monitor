<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

interface HealthDataRepository
{
    /**
     * @throws DuplicatedResourceException
     */
    public function store(HealthData $healthData): void;

    /**
     * @return HealthData[]
     */
    public function getByUser(string $userID): array;

    public function getById(string $healthDataId): ?HealthData;

    public function update(HealthData $hd): void;
}
