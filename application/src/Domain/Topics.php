<?php declare(strict_types=1);

namespace HealthMonitor\Domain;

enum Topics: string
{
    case NEW_HEALTH_DATA = 'new-health-data-added-event';
}
