<?php declare(strict_types=1);

namespace HealthMonitor\Application\StoreHealthData;

use HealthMonitor\Domain\HealthData;
use HealthMonitor\Domain\QueueMessage;
use HealthMonitor\Domain\QueueProducer;
use HealthMonitor\Domain\Topic;

class Producer
{
    public function __construct(
        private QueueProducer $producer
    ) {
    }

    public function produce(HealthData $healthData): void
    {
        $message = new QueueMessage(
            Topic::NEW_HEALTH_DATA,
            $healthData->id,
            [
                'id' => $healthData->id,
            ]
        );

        $this->producer->produce($message);
    }
}
