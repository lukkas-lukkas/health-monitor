<?php declare(strict_types=1);

namespace HealthMonitor\UI\Http\Controllers;

use HealthMonitor\Application\GetHealthDataByUser\GetHealthDataByUserHandler;

class GetHealthDataByUserController
{
    public function __construct(private GetHealthDataByUserHandler $handler)
    {
    }

    public function __invoke(string $userId)
    {
        return response()->json(
            $this->handler->handle($userId)
        );
    }
}
