<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Kafka;

use Enqueue\Consumption\QueueConsumer;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use HealthMonitor\Domain\Topic;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;
use Interop\Queue\Producer;
use Interop\Queue\Topic as InteropTopic;

class KafkaManager
{
    private array $config;
    private Context $context;

    public function __construct()
    {
        $this->config = config('kafka');
    }

    public function createMessage(string $body, array $properties, array $headers): Message
    {
        return $this->getContext()->createMessage(
            $body,
            $properties,
            $headers,
        );
    }

    public function createTopic(Topic $topic): InteropTopic
    {
        return $this->getContext()->createTopic($topic->value);
    }

    public function createProducer(): Producer
    {
        return $this->getContext()->createProducer();
    }

    public function createConsumer(Topic $topic, Processor $processor): QueueConsumer
    {
        $consumer = new QueueConsumer($this->getContext());
        $consumer->bind($topic->value, $processor);
        return $consumer;
    }

    public function setGroupId(string $groupId): void
    {
        $this->config['global']['group.id'] = $groupId;
    }

    private function getContext(): Context
    {
        if (!isset($this->context)) {
            $factory = new RdKafkaConnectionFactory($this->config);
            $this->context = $factory->createContext();
        }

        return $this->context;
    }
}
