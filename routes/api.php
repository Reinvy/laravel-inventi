<?php

use Illuminate\Support\Facades\Route;


Route::prefix('/auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\UserController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('/user')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Api\UserController::class, 'profile']);
    Route::put('/update-profile', [App\Http\Controllers\Api\UserController::class, 'update']);
    Route::post('/change-password', [App\Http\Controllers\Api\UserController::class, 'changePassword']);
    Route::post('/change-photo', [App\Http\Controllers\Api\UserController::class, 'changePhoto']);
    Route::post('/add-user', [App\Http\Controllers\Api\UserController::class, 'addUser']);
    Route::get('/get-users', [App\Http\Controllers\Api\UserController::class, 'getUsers']);
    Route::put('/update-user-by-id/{id}', [App\Http\Controllers\Api\UserController::class, 'updateUserById']);
    Route::post('/change-photo-by-id/{id}', [App\Http\Controllers\Api\UserController::class, 'changePhotoById']);
    Route::delete('/delete-user-by-id/{id}', [App\Http\Controllers\Api\UserController::class, 'deleteUserById']);
});
