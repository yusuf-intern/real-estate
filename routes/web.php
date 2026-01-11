<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerContractController;
use App\Http\Controllers\TenantContractController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SubunitController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PaymentController;

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('owner-contracts', OwnerContractController::class);
    Route::resource('tenant-contracts', TenantContractController::class);
    
    Route::resource('buildings', BuildingController::class);
    Route::resource('units', UnitController::class);
    Route::resource('subunits', SubunitController::class);
    
    Route::resource('owners', OwnerController::class);
    Route::resource('tenants', TenantController::class);
    
    Route::resource('payments', PaymentController::class);
});