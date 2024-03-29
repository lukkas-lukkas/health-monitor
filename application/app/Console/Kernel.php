<?php

namespace App\Console;

use HealthMonitor\UI\Console\AnomaliesAnalyserCommand;
use HealthMonitor\UI\Console\DeviceSimulatorCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        $this->commands = [
            DeviceSimulatorCommand::class,
            AnomaliesAnalyserCommand::class,
        ];

        require base_path('routes/console.php');
    }
}
