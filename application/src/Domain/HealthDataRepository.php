<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

interface HealthDataRepository
{
    /**
     * @throws DuplicatedResourceException
     */
    public function store(HealthData $healthData): void;
}
