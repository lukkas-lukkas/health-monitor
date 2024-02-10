<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Hash;

use HealthMonitor\Domain\IdGenerator;

class Md5IdGenerator implements IdGenerator
{
    private const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function generate(string $userID, \DateTimeInterface $startedAt, \DateTimeInterface $finishedAt): string
    {
        $key = sprintf(
            "%s-%s-%-s",
            $userID,
            $startedAt->format(self::DATE_FORMAT),
            $finishedAt->format(self::DATE_FORMAT),
        );

        return md5($key);
    }
}
