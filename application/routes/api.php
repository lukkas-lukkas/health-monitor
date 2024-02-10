<?php

use HealthMonitor\UI\Http\Controllers\GetHealthDataByUserController;
use HealthMonitor\UI\Http\Controllers\StoreHealthDataController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/users/{userID}/health-data', GetHealthDataByUserController::class);
Route::post('/v1/users/{userID}/health-data', StoreHealthDataController::class);
