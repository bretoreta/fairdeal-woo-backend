<?php

use App\Http\Controllers\Employees\CodesController;
use App\Http\Controllers\Employees\CustomersController;
use App\Http\Controllers\Employees\DashboardController;
use App\Http\Controllers\Employees\ProfileController;
use App\Http\Controllers\Employees\ReviewsController;
use App\Http\Controllers\Employees\SalesPersonController;
use App\Http\Middleware\EnsureEmployeeHasShowroom;
use App\Http\Middleware\ShareEmployeeShowroom;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Employees Routes
|--------------------------------------------------------------------------
|
| Here is where you can register employees routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "employees" middleware group. Now create something great!
|
*/

Route::prefix('employees')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', EnsureEmployeeHasShowroom::class, ShareEmployeeShowroom::class])->group( function() {
    // Management of dashboard
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('employees.dashboard');
        Route::get('/quick-stats', [DashboardController::class, 'quickStats'])->name('employees.stats.quick');
    });

    // Management of customers
    Route::prefix('customers')->group(function() {
        Route::get('/', [CustomersController::class, 'index'])->name('employees.customers.index');
        Route::get('/create', [CustomersController::class, 'create'])->name('employees.customers.create');
        Route::get('/{user:username}', [CustomersController::class, 'show'])->name('employees.customers.show');
        Route::post('/{user:username}/activate', [CustomersController::class, 'activate'])->name('employees.customers.activate');
        Route::post('/{user:username}/deactivate', [CustomersController::class, 'deactivate'])->name('employees.customers.deactivate');
        Route::post('/{user:username}/verify', [CustomersController::class, 'verify'])->name('employees.customers.verify');
        Route::post('/{user:username}/unverify', [CustomersController::class, 'unverify'])->name('employees.customers.unverify');
        Route::post('/{user:username}/issuecode', [CustomersController::class, 'issuecode'])->name('employees.customers.issuecode');
        Route::post('/store', [CustomersController::class, 'store'])->name('employees.customers.store');
        Route::put('/{user:username}/update', [CustomersController::class, 'update'])->name('employees.customers.update');
    });

    // Management of salespersons
    Route::prefix('salespersons')->group(function() {
        Route::get('/', [SalesPersonController::class, 'index'])->name('employees.salesperson.index');
        Route::get('/create', [SalesPersonController::class, 'create'])->name('employees.salesperson.create');
        Route::post('/store', [SalesPersonController::class, 'store'])->name('employees.salesperson.store');
        Route::get('/leaderboard', [SalesPersonController::class, 'leaderboard'])->name('employees.salesperson.leaderboard');
        Route::get('/{user:username}', [SalesPersonController::class, 'show'])->name('employees.salesperson.show');
        Route::post('/{user:username}/activate', [SalesPersonController::class, 'activate'])->name('employees.salesperson.activate');
        Route::post('/{user:username}/deactivate', [SalesPersonController::class, 'deactivate'])->name('employees.salesperson.deactivate');
        Route::post('/{user:username}/verify', [SalesPersonController::class, 'verify'])->name('employees.salesperson.verify');
        Route::post('/{user:username}/unverify', [SalesPersonController::class, 'unverify'])->name('employees.salesperson.unverify');
        Route::post('/{user:username}/block', [SalesPersonController::class, 'block'])->name('employees.salesperson.block');
        Route::post('/{user:username}/unblock', [SalesPersonController::class, 'unblock'])->name('employees.salesperson.unblock');
        Route::post('/{user:username}/issuecode', [SalesPersonController::class, 'issuecode'])->name('employees.salesperson.issuecode');
        Route::post('/{user:username}/invalidatecode', [SalesPersonController::class, 'invalidatecode'])->name('employees.salesperson.invalidatecode');
        Route::put('/{user:username}/update', [SalesPersonController::class, 'update'])->name('employees.salesperson.update');
        Route::delete('/{user:username}', [SalesPersonController::class, 'delete'])->name('employees.salesperson.delete');
    });

    // Management of reviews
    Route::prefix('reviews')->group(function() {
        Route::get('/', [ReviewsController::class, 'index'])->name('employees.reviews.index');
        Route::post('/generate', [ReviewsController::class, 'generate'])->name('employees.reviews.generate');
        Route::get('/result', [ReviewsController::class, 'result'])->name('employees.reviews.result');
    });

    // Management of codes
    Route::prefix('codes')->group(function() {
        Route::post('/{code:token}/redeem', [CodesController::class, 'redeem'])->name('employees.codes.redeem');
    });

    // Management of profile
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('employees.profile.show');
});