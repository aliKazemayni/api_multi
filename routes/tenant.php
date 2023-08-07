<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::post('/auth/login'   , [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('company' , CompanyController::class);
    Route::middleware(['api', InitializeTenancyByDomain::class])->group(function () {

    });
});
