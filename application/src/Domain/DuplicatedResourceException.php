<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

class DuplicatedResourceException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The resource already exist", 409);
    }
}
