<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CodesController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SalesPersonController;
use App\Http\Controllers\Admin\ShowroomsController;
use App\Http\Controllers\Admin\SyncController;
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

    // Management of products
    Route::prefix('products')->group(function() {
        Route::get('/', [ProductsController::class, 'index'])->name('admin.products.index');
        Route::get('/pull', [ProductsController::class, 'pull'])->name('admin.products.pull');
        Route::post('/{product}/feature', [ProductsController::class, 'feature'])->name('admin.products.feature');
        Route::post('/{product}/unfeature', [ProductsController::class, 'unfeature'])->name('admin.products.unfeature');
        Route::post('/store', [ProductsController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('admin.products.edit');
        Route::put('/{product}/update', [ProductsController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}/delete', [ProductsController::class, 'delete'])->name('admin.products.delete');
    });

    // Management of categories
    Route::prefix('categories')->group(function() {
        Route::get('/', [CategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/pull', [CategoriesController::class, 'pull'])->name('admin.categories.pull');
        Route::post('/store', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/{product}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{product}/update', [CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{product}/delete', [CategoriesController::class, 'delete'])->name('admin.categories.delete');
    });

    // Management of Sync Manager
    Route::prefix('sync')->group(function() {
        Route::post('/dispatch', [SyncController::class, 'dispatch'])->name('admin.sync.dispatch');
    });

    // Management of Database Notifications
    Route::prefix('notifications')->group(function() {
        Route::post('/markallasread', [NotificationsController::class, 'markallasread'])->name('admin.notifications.markallasread');
    });

    // Management of profile
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('admin.profile.show');
});