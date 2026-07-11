<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Core\BranchController;
use App\Http\Controllers\Api\Core\CompanyController;
use App\Http\Controllers\Api\Core\ContactController;
use App\Http\Controllers\Api\Core\DeptController;
use App\Http\Controllers\Api\Core\ModuleController;
use App\Http\Controllers\Api\Core\TaskController;
use App\Http\Controllers\Api\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/erp/example', [ExampleController::class, 'index']);
Route::post('/erp/example', [ExampleController::class, 'store']);

Route::post('/erp/login', [LoginController::class, 'login']);
Route::post('/erp/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('erp')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/switch-company', [AuthController::class, 'switchCompany']);

    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('depts', DeptController::class);
    Route::apiResource('contacts', ContactController::class);
    Route::apiResource('tasks', TaskController::class);

    // إدارة الموديولات
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{alias}/enable', [ModuleController::class, 'enable']);
    Route::post('/modules/{alias}/disable', [ModuleController::class, 'disable']);
});

// Store Public API — loaded from routes/store-api.php
