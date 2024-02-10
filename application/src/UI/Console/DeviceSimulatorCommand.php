<?php declare(strict_types=1);

namespace HealthMonitor\UI\Console;

use Carbon\Carbon;
use HealthMonitor\Application\StoreHealthData\HealthDataDTO;
use HealthMonitor\Application\StoreHealthData\StoreHealthDataHandler;
use Illuminate\Console\Command;

class DeviceSimulatorCommand extends Command
{
    protected $signature = 'simulator:init {--quantity=500} {--delay=1}';
    protected $description = 'Simulate a smart device sending data to api';

    public function handle(StoreHealthDataHandler $handler): void
    {
        if (env('ENABLE_AI')) {
            $this->error("ERROR: Simulator disabled when using AI, try set env ENABLE_AI to false and try again.");
            return;
        }

        $quantity = $this->option('quantity');
        $delay = $this->option('delay');

        if (
            !filter_var($quantity, FILTER_VALIDATE_INT)
            || (!filter_var($delay, FILTER_VALIDATE_INT) && $delay != 0)
        ) {
            $this->error("ERROR: Expected only integer options.");
            return;
        }

        $this->info("Process initialized");
        $this->info(sprintf("Quantity: %d", $quantity));
        $this->info(sprintf("Delay: %ds", $delay));
        $this->newLine();

        for ($i = 1; $i <= $quantity; $i++) {
            $dto = new HealthDataDTO(
                uniqid(),
                Carbon::now(),
                Carbon::now()->addMinutes(random_int(1, 10)),
                random_int(60, 200),
                random_int(10, 1000),
            );

            $result = $handler->handle($dto);

            $this->info(sprintf("Added: %s", json_encode($result)));
            sleep((int) $delay);
        }
    }
}
