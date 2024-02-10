<?php declare(strict_types=1);

namespace HealthMonitor\UI\Http\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class DateGreaterThan implements ValidationRule
{
    public function __construct(
        private Request $request,
        private string $lessField,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lessDate = Carbon::parse(
            $this->request->get($this->lessField),
        );
        $greaterDate = Carbon::parse($value);

        if ($lessDate->greaterThan($greaterDate)) {
            $fail(sprintf('The field :attribute must be greater then %s', $this->lessField));
        }
    }
}
