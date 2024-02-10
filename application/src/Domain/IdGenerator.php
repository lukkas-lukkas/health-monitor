<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

interface IdGenerator
{
    public function generate(string $userID, \DateTimeInterface $startedAt, \DateTimeInterface $finishedAt): string;
}
