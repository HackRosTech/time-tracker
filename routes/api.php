<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('projects', [ProjectController::class, 'create']);
    Route::get('projects', [ProjectController::class, 'index']);

    Route::post('tasks', [TaskController::class, 'store']);
    Route::get('task/{task}', [TaskController::class, 'show']);

    Route::post('statistics/start', [StatisticController::class,'start']);
    Route::post('statistics/stop', [StatisticController::class,'stop']);
    Route::post('statistics/time', [StatisticController::class, 'getTaskTimeInfo']); // rename
    Route::get('statistics/task', [StatisticController::class,'getTaskStatistics']);
    Route::get('statistics/projects', [StatisticController::class,'getProjectsWithStatistics']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

