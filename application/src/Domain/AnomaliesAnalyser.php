<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

interface AnomaliesAnalyser
{
    public function findAnomalies(HealthData $healthData): string;
}
