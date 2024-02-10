<?php declare(strict_types=1);

namespace Tests\Unit\UI\Http\Rules;

use Carbon\Carbon;
use HealthMonitor\UI\Http\Rules\DateGreaterThan;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class DateGreaterThanTest extends TestCase
{
    private const DATE_FORMAT = 'Y-m-d\TH:i:s';

    private Request $request;
    private string $now;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createMock(Request::class);
        $this->now = Carbon::now()->format(self::DATE_FORMAT);
    }

    public function testShouldPassValidation(): void
    {
        $lessDate = Carbon::now()->subMinute()->format(self::DATE_FORMAT);

        $fieldName = 'started_at';

        $this->request
            ->expects($this->once())
            ->method('get')
            ->with($fieldName)
            ->willReturn($lessDate);

        $rule = new DateGreaterThan(
            $this->request,
            $fieldName,
        );

        $fail = function (string $error) {
            $this->fail('Should not execute fail closure');
        };

        $rule->validate('attr', $this->now, $fail);
    }

    public function testShouldNotPassValidation(): void
    {
        $lessDate = Carbon::now()->addMinute()->format(self::DATE_FORMAT);

        $fieldName = 'started_at';

        $this->request
            ->expects($this->once())
            ->method('get')
            ->with($fieldName)
            ->willReturn($lessDate);

        $rule = new DateGreaterThan(
            $this->request,
            $fieldName,
        );

        $fail = function (string $error) {
            $this->assertEquals('The field :attribute must be greater then started_at', $error);
        };

        $rule->validate('attr', $this->now, $fail);
    }
}
