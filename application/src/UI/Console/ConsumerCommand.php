<?php declare(strict_types=1);

namespace HealthMonitor\UI\Console;

use Enqueue\Consumption\QueueConsumer;
use HealthMonitor\Domain\Topic;
use HealthMonitor\Infrastructure\Kafka\KafkaManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;

abstract class ConsumerCommand extends Command implements Processor
{
    protected string $consumerGroup;
    protected Topic $topic;

    private QueueConsumer $consumer;

    public function __construct(
        private KafkaManager $kafkaManager,
    ) {
        $this->kafkaManager->setGroupId($this->consumerGroup);
        $this->consumer = $this->kafkaManager->createConsumer($this->topic, $this);

        parent::__construct();
    }

    public function __invoke(): void
    {
        $this->consumer->consume();
    }

    public function process(Message $message, Context $context): string
    {
        try {
            $this->consume($message);
            return self::ACK;
        } catch (\Throwable $throwable) {
            $this->error(json_encode([
                'message' => 'consumer_command_error',
                'topic' => $this->topic->value,
                'consumer_group' => $this->consumerGroup,
                'exception' => $throwable,
            ]));

            // Here we could send to a DLQ, but let's just reject
            return self::REJECT;
        }
    }

    abstract function consume(Message $message): void;
}
