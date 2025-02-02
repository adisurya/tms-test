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
    Route::get('tasks/total-assign-to-me', [TaskController::class,'totalAssignToMe'])->name('tasks.total-assign-to-me');
    Route::get('tasks/assign-to-me', [TaskController::class,'assignToMe'])->name('tasks.assign-to-me');

    Route::apiResource('tasks', TaskController::class);
    Route::get('users', [UserControlller::class,'index'])->name('users.index');

    Route::post('/logout', [AuthController::class, 'logout']);
});
