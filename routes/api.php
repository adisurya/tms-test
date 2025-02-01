<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserControlller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('tasks/my-tasks-notification', [TaskController::class,'myTaskNotification'])->name('tasks.my-tasks-notification');

    Route::apiResource('tasks', TaskController::class);
    Route::get('users', [UserControlller::class,'index'])->name('users.index');

    Route::post('/logout', [AuthController::class, 'logout']);
});
