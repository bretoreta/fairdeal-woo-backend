<?php

use App\Http\Controllers\Common\BugsreportController;
use App\Http\Controllers\Common\ImagesController;
use App\Http\Controllers\Common\SupportController;
use App\Http\Controllers\Common\RedirectsController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Codexshaper\WooCommerce\Facades\Product as WooCommerceProduct;
use App\Models\Product;
use App\Models\SyncTransaction;
use Illuminate\Support\Collection;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/redirects', [RedirectsController::class, 'index'])->name('redirects');

Route::get('/', function () {
    return redirect('login');
})->name('index');

Route::get('/test', function() {
    $products = WooCommerceProduct::all([
        'fields' => 'id,name,slug,featured,description,short_description,sku,regular_price,sale_price,manage_stock,stock_quantity,stock_status,attributes,categories'
    ]);

    dd($products);
});

Route::prefix('support')->group(function() {
    Route::get('/',[SupportController::class,'index'])->name('support.index');
    Route::post('/send', [SupportController::class, 'send'])->name('support.send');
});

Route::prefix('bugs')->group(function() {
    Route::get('/',[BugsreportController::class,'index'])->name('bugs.index');
    Route::post('/send', [BugsreportController::class, 'send'])->name('bugs.send');
});

Route::middleware('auth:sanctum')->group(function() {
    // Image uploading
    Route::prefix('images')->group(function() {
        Route::post('upload', [ImagesController::class, 'upload'])->name('web.images.upload');
        Route::delete('{image:uuid}/delete', [ImagesController::class, 'delete'])->name('web.images.delete');
    });
});