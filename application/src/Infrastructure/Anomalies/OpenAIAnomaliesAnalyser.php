<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Anomalies;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use HealthMonitor\Domain\AnomaliesAnalyser;
use HealthMonitor\Domain\HealthData;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class OpenAIAnomaliesAnalyser implements AnomaliesAnalyser
{
    private string $uri = '/v1/chat/completions';
    private array $config;

    private Client $client;

    public function __construct()
    {
        $this->config = (array) config('openai');
        $this->client = new Client($this->config['client']);
    }

    public function findAnomalies(HealthData $healthData): string
    {
        $options = [
            RequestOptions::HEADERS => [
                'Authorization' => sprintf('Bearer %s', $this->config['credentials']['token']),
            ],
            RequestOptions::JSON => $this->createPayload($healthData),
        ];

        $response = $this->client->post($this->uri, $options);

        if ($response->getStatusCode() !== 200) {
            $this->exceptionHandler($response, $healthData);
        }

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['choices'][0]['message']['content'];
    }

    private function createPayload(HealthData $healthData): array
    {
        $data = $healthData->toArray();

        $content = sprintf(
            'Am I healthy? Based on this activity: started at %s, finished at %s, average bit per minute %d and total of steps %d',
            $data['started_at'],
            $data['finished_at'],
            $data['avg_bpm'],
            $data['steps_total'],
        );
        return  [
            'model' => $this->config['model'],
            'messages' => [
                $this->config['anomalies']['role'],
                [
                    'role' => 'user',
                    'content' => $content,
                ]
            ],
        ];
    }

    private function exceptionHandler(ResponseInterface $response, HealthData $healthData)
    {
        Log::error('openai_integration_error', [
            'status_code' => $response->getStatusCode(),
            'body' => $response->getBody()->getContents(),
            'heath_data_id' => $healthData->id,
        ]);
        throw new RuntimeException('OpenAI integration error');
    }
}
