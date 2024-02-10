<?php

use HealthMonitor\UI\Http\Controllers\StoreHealthDataController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/users/{userID}/health-data', StoreHealthDataController::class);
