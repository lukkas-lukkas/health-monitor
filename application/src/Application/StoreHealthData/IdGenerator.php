<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

class IdGenerator
{
    private const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function generate(HealthDataDTO $dto): string
    {
        $key = sprintf(
            "%s-%s-%-s",
            $dto->userID,
            $dto->startedAt->format(self::DATE_FORMAT),
            $dto->finishedAt->format(self::DATE_FORMAT),
        );

        return md5($key);
    }
}
