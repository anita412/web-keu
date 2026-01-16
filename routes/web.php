<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SahamController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect('/login'); });
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('aset')->name('aset.')->group(function () {
        Route::get('/', [AsetController::class, 'index'])->name('index');
        Route::get('/create', [AsetController::class, 'create'])->name('create');
        Route::post('/store', [AsetController::class, 'store'])->name('store');
        Route::post('/simpan-saldo', [AsetController::class, 'updateSaldo'])->name('updateSaldo');
        Route::get('/{id}/edit', [AsetController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AsetController::class, 'update'])->name('update');
        Route::delete('/{id}', [AsetController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('saham')->name('saham.')->group(function () {
        Route::get('/', [SahamController::class, 'index'])->name('index');
        Route::get('/create', [SahamController::class, 'create'])->name('create');
        Route::post('/store', [SahamController::class, 'store'])->name('store');
        Route::post('/simpan-saldo', [SahamController::class, 'updateSaldo'])->name('updateSaldo');
        Route::get('/{id}/edit', [SahamController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SahamController::class, 'update'])->name('update');
        Route::delete('/{id}', [SahamController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('income')->name('income.')->group(function () {
        Route::get('/', [IncomeController::class, 'index'])->name('index');        
        Route::get('/create', [IncomeController::class, 'create'])->name('create');        
        Route::post('/', [IncomeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [IncomeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [IncomeController::class, 'update'])->name('update');
        Route::delete('/{id}', [IncomeController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('index');        
        Route::get('/create', [MaintenanceController::class, 'create'])->name('create');        
        Route::post('/', [MaintenanceController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MaintenanceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MaintenanceController::class, 'update'])->name('update');
        Route::delete('/{id}', [MaintenanceController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('saving')->name('saving.')->group(function () {
        Route::get('/', [SavingController::class, 'index'])->name('index');        
        Route::get('/create', [SavingController::class, 'create'])->name('create');        
        Route::post('/', [SavingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SavingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SavingController::class, 'update'])->name('update');
        Route::delete('/{id}', [SavingController::class, 'destroy'])->name('destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



