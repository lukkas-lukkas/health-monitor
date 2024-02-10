<?php declare(strict_types=1);

namespace HealthMonitor\Application\AnomaliesAnalyse;

use HealthMonitor\Domain\AnomaliesAnalyser;
use HealthMonitor\Domain\HealthDataRepository;

class AnomaliesAnalyseHandler
{
    public function __construct(
        private HealthDataRepository $repository,
        private AnomaliesAnalyser $anomaliesAnalyser,
    ) {
    }

    public function handle(string $healthDataId): void
    {
        $hd = $this->repository->getById($healthDataId);
        if (is_null($hd) || $hd->getAnomalies() !== null) {
            return;
        }

        $hd->setAnomalies(
            $this->anomaliesAnalyser->findAnomalies($hd),
        );

        $this->repository->update($hd);
    }
}
