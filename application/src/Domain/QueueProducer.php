<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

interface QueueProducer
{
    public function produce(QueueMessage $message): void;
}
