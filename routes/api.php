<?php

use App\Http\Controllers\Auth\Logincontroller;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TodolistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// auth
Route::post('/register',RegisterController::class);
Route::post('/login',Logincontroller::class);
Route::post('/logout',LogoutController::class)->middleware('auth:sanctum');

Route::apiResource('/todos',TodolistController::class)->middleware('auth:sanctum');