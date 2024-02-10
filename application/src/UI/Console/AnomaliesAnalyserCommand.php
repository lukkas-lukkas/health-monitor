<?php declare(strict_types=1);

namespace HealthMonitor\UI\Console;

use HealthMonitor\Application\AnomaliesAnalyse\AnomaliesAnalyseHandler;
use HealthMonitor\Domain\Topic;
use HealthMonitor\Infrastructure\Kafka\KafkaManager;
use Interop\Queue\Message;

class AnomaliesAnalyserCommand extends ConsumerCommand
{
    protected Topic $topic = Topic::NEW_HEALTH_DATA;
    protected string $consumerGroup = 'anomalies:analyse';

    protected $signature = 'anomalies:analyse';
    protected $description = 'Analyse a new health data and looking for anomalies.';

    public function __construct(
        KafkaManager $kafkaManager,
        private AnomaliesAnalyseHandler $handler,
    ) {
        parent::__construct($kafkaManager);
    }

    function consume(Message $message): void
    {
        $data = json_decode($message->getBody(), true);

        $id = $data['id'];

        $this->handler->handle($id);

        $this->info(sprintf("Processed: %s", $id));
    }
}
