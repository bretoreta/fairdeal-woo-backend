<?php

use App\Http\Controllers\Admin\CodesController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SalesPersonController;
use App\Http\Controllers\Admin\ShowroomsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group( function() {
    // Management of dashboard
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/quick-stats', [DashboardController::class, 'quickStats'])->name('admin.stats.quick');
    });

    // Management of employees
    Route::prefix('employees')->group(function() {
        Route::get('/', [EmployeesController::class, 'index'])->name('admin.employees.index');
        Route::get('/create', [EmployeesController::class, 'create'])->name('admin.employees.create');
        Route::get('/{user:username}', [EmployeesController::class, 'show'])->name('admin.employees.show');
        Route::post('/{user:username}/activate', [EmployeesController::class, 'activate'])->name('admin.employees.activate');
        Route::post('/{user:username}/deactivate', [EmployeesController::class, 'deactivate'])->name('admin.employees.deactivate');
        Route::post('/{user:username}/verify', [EmployeesController::class, 'verify'])->name('admin.employees.verify');
        Route::post('/{user:username}/unverify', [EmployeesController::class, 'unverify'])->name('admin.employees.unverify');
        Route::post('/{user:username}/block', [EmployeesController::class, 'block'])->name('admin.employees.block');
        Route::post('/{user:username}/unblock', [EmployeesController::class, 'unblock'])->name('admin.employees.unblock');
        Route::post('/store', [EmployeesController::class, 'store'])->name('admin.employees.store');
        Route::put('/{user:username}/update', [EmployeesController::class, 'update'])->name('admin.employees.update');
        Route::delete('/{user:username}', [EmployeesController::class, 'delete'])->name('admin.employees.delete');
    });

    // Management of salespersons
    Route::prefix('salespersons')->group(function() {
        Route::get('/', [SalesPersonController::class, 'index'])->name('admin.salesperson.index');
        Route::get('/create', [SalesPersonController::class, 'create'])->name('admin.salesperson.create');
        Route::post('/store', [SalesPersonController::class, 'store'])->name('admin.salesperson.store');
        Route::get('/leaderboard', [SalesPersonController::class, 'leaderboard'])->name('admin.salesperson.leaderboard');
        Route::get('/{user:username}', [SalesPersonController::class, 'show'])->name('admin.salesperson.show');
        Route::post('/{user:username}/activate', [SalesPersonController::class, 'activate'])->name('admin.salesperson.activate');
        Route::post('/{user:username}/deactivate', [SalesPersonController::class, 'deactivate'])->name('admin.salesperson.deactivate');
        Route::post('/{user:username}/verify', [SalesPersonController::class, 'verify'])->name('admin.salesperson.verify');
        Route::post('/{user:username}/unverify', [SalesPersonController::class, 'unverify'])->name('admin.salesperson.unverify');
        Route::post('/{user:username}/block', [SalesPersonController::class, 'block'])->name('admin.salesperson.block');
        Route::post('/{user:username}/unblock', [SalesPersonController::class, 'unblock'])->name('admin.salesperson.unblock');
        Route::post('/{user:username}/issuecode', [SalesPersonController::class, 'issuecode'])->name('admin.salesperson.issuecode');
        Route::post('/{user:username}/invalidatecode', [SalesPersonController::class, 'invalidatecode'])->name('admin.salesperson.invalidatecode');
        Route::put('/{user:username}/update', [SalesPersonController::class, 'update'])->name('admin.salesperson.update');
        Route::delete('/{user:username}', [SalesPersonController::class, 'delete'])->name('admin.salesperson.delete');
    });

    // Management of customers
    Route::prefix('customers')->group(function() {
        Route::get('/', [CustomersController::class, 'index'])->name('admin.customers.index');
        Route::get('/create', [CustomersController::class, 'create'])->name('admin.customers.create');
        Route::get('/{user:username}', [CustomersController::class, 'show'])->name('admin.customers.show');
        Route::post('/{user:username}/activate', [CustomersController::class, 'activate'])->name('admin.customers.activate');
        Route::post('/{user:username}/deactivate', [CustomersController::class, 'deactivate'])->name('admin.customers.deactivate');
        Route::post('/{user:username}/verify', [CustomersController::class, 'verify'])->name('admin.customers.verify');
        Route::post('/{user:username}/unverify', [CustomersController::class, 'unverify'])->name('admin.customers.unverify');
        Route::post('/{user:username}/block', [CustomersController::class, 'block'])->name('admin.customers.block');
        Route::post('/{user:username}/unblock', [CustomersController::class, 'unblock'])->name('admin.customers.unblock');
        Route::post('/{user:username}/issuecode', [CustomersController::class, 'issuecode'])->name('admin.customers.issuecode');
        Route::post('/{user:username}/invalidatecode', [CustomersController::class, 'invalidatecode'])->name('admin.customers.invalidatecode');
        Route::post('/store', [CustomersController::class, 'store'])->name('admin.customers.store');
        Route::put('/{user:username}/update', [CustomersController::class, 'update'])->name('admin.customers.update');
        Route::delete('/{user:username}', [CustomersController::class, 'delete'])->name('admin.customers.delete');
    });

    // Management of codes
    Route::prefix('codes')->group(function() {
        Route::post('/{code:token}/redeem', [CodesController::class, 'redeem'])->name('admin.codes.redeem');
    });

    // Management of reviews
    Route::prefix('reviews')->group(function() {
        Route::get('/', [ReviewsController::class, 'index'])->name('admin.reviews.index');
        Route::post('/generate', [ReviewsController::class, 'generate'])->name('admin.reviews.generate');
        Route::get('/result', [ReviewsController::class, 'result'])->name('admin.reviews.result');
    });

    // Management of Showrooms
    Route::prefix('showrooms')->group(function() {
        Route::get('/', [ShowroomsController::class,'index'])->name('admin.showrooms.index');
        Route::get('/create', [ShowroomsController::class, 'create'])->name('admin.showrooms.create');
        Route::get('/{showroom}', [ShowroomsController::class, 'show'])->name('admin.showrooms.show');
        Route::post('/store', [ShowroomsController::class, 'store'])->name('admin.showrooms.store');
        Route::put('/{showroom}/update', [ShowroomsController::class, 'update'])->name('admin.showrooms.update');
        Route::post('/{showroom}/activate', [ShowroomsController::class, 'activate'])->name('admin.showrooms.activate');
        Route::post('/{showroom}/deactivate', [ShowroomsController::class, 'deactivate'])->name('admin.showrooms.deactivate');
        Route::delete('/{showroom}', [ShowroomsController::class, 'delete'])->name('admin.showrooms.delete');
    });

    // Management of profile
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('admin.profile.show');
});