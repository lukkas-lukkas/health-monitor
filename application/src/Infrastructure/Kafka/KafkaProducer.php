<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Kafka;

use HealthMonitor\Domain\QueueMessage;
use HealthMonitor\Domain\QueueProducer;

class KafkaProducer implements QueueProducer
{
    public function __construct(private KafkaManager $kafkaManager)
    {
    }

    public function produce(QueueMessage $message): void
    {
        $topic = $this->kafkaManager->createTopic($message->topic);

        $queueMessage = $this->kafkaManager->createMessage(
            json_encode($message->body),
            $message->properties,
            $message->headers,

        );

        $queueMessage->setKey($message->key);

        $this->kafkaManager->createProducer()->send($topic, $queueMessage);
    }
}
