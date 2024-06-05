<?php

use App\Http\Controllers\Api\CodesController;
use App\Http\Controllers\Api\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes for Auth API
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes for Customers API
Route::prefix('products')->group(function() {
    Route::get('/', [ProductsController::class, 'index'])->name('api.products.index');
    Route::post('/store', [ProductsController::class, 'store'])->name('api.products.store');
});