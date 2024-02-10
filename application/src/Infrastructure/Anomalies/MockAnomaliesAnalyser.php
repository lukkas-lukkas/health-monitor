<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Anomalies;

use HealthMonitor\Domain\AnomaliesAnalyser;
use HealthMonitor\Domain\HealthData;
use Illuminate\Support\Str;

class MockAnomaliesAnalyser implements AnomaliesAnalyser
{
    public function findAnomalies(HealthData $healthData): string
    {
        return sprintf("Some anomaly: %s", Str::random('5'));
    }
}
