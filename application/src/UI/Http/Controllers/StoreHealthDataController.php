<?php declare(strict_types=1);

namespace HealthMonitor\UI\Http\Controllers;

use HealthMonitor\UI\Http\Rules\DateGreaterThan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class StoreHealthDataController extends Controller
{
    public function __invoke(string $userId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'started_at' => ['required', 'date_format:Y-m-d\TH:i:s'],
            'finished_at' => [
                'required',
                'date_format:Y-m-d\TH:i:s',
                new DateGreaterThan($request, 'started_at'),
            ],
            'avg_bpm' => ['required', 'integer'],
            'steps_total' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 422);
        }
        $data = $validator->validated();
        $data['user_id'] = $userId;

        return response()->json($data);
    }
}
