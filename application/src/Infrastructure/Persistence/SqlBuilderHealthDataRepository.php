<?php declare(strict_types=1);

namespace HealthMonitor\Infrastructure\Persistence;

use HealthMonitor\Domain\DuplicatedResourceException;
use HealthMonitor\Domain\HealthData;
use HealthMonitor\Domain\HealthDataRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;

class SqlBuilderHealthDataRepository implements HealthDataRepository
{
    private string $table = 'health_data';

    public function store(HealthData $healthData): void
    {
        try {
            $this->connection()->insert($healthData->toArray());
        } catch (UniqueConstraintViolationException) {
            throw new DuplicatedResourceException();
        }
    }

    public function getByUser(string $userID): array
    {
        $hds = $this->connection()->where('user_id', '=', $userID)->get();

        return array_map(function ($item) {
            return HealthData::fromArray((array) $item);
        }, $hds->all());
    }

    public function getById(string $healthDataId): ?HealthData
    {
        $hd = $this->connection()
            ->where('id', '=', $healthDataId)
            ->first();

        return is_null($hd) ? null : HealthData::fromArray((array) $hd);
    }

    public function update(HealthData $hd): void
    {
        $this->connection()
            ->where('id', '=', $hd->id)
            ->update($hd->toArray());
    }

    private function connection(): Builder
    {
        return DB::table($this->table);
    }
}
