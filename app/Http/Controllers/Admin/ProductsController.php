<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PullProducts;
use App\Models\Product;
use App\Models\SyncTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function index () {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::with('categories')->paginate(),
            'activeSync' => (SyncTransaction::where('status', 'running')->count() > 0)
        ]);
    }

    public function create () {
        return Inertia::render('Admin/Products/Create');
    }

    public function pull (Request $request) {
        PullProducts::dispatch($request->user());

        // Create the lock to disable the Sync Job being submitted again
        SyncTransaction::create([
            'user_id' => $request->user()->id,
            'status' => 'running',
            'data' => [
                'message' => "Pull sync started by ".$request->user()->name,
                'sync_type' => 'pull',
                'started_at' => now(),
                'ended_at' => null,
            ]
        ]);

        return back()->with('message', [
            'type' => 'success',
            'message' => 'Process initiated! Products are being pulled in the background.'
        ]);
    }

    public function edit (Product $product) {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product
        ]);
    }

    public function update (Request $request, Product $product) {
        $product->update([
            'name' => $product->name,
            'featured' => $product->featured,
            'description' => $product->description,
            'short_description' => $product->short_description,
            'regular_price' => $product->regular_price,
            'sale_price' => $product->sale_price,
            'manage_stock' => $product->manage_stock,
            'stock_quantity' => $product->stock_quantity,
            'stock_status' => $product->stock_status,
            'product_status' => $product->status,
            'attributes' => $product->attributes,
            'sync_status' => 'notsynced',
        ]);

        return redirect(route('admin.products.index'))->with('message', [
            'type' => 'success',
            'message' => "Product #{$product->id} has been updated successfully."
        ]);
    }
}
