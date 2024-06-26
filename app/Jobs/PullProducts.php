<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Codexshaper\WooCommerce\Facades\Product as WooCommerceProduct;
use App\Models\Product;
use App\Models\SyncTransaction;
use App\Models\User;
use App\Notifications\Admin\SyncFailedNotification;
use App\Notifications\Admin\SyncFinishedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class PullProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $actor)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $per_page = 100;
        $page = 1;

        do {
            // Pull products 100 per loop
            $products = WooCommerceProduct::all([
                'per_page' => $per_page,
                'page' => $page,
                'fields' => 'id,name,slug,featured,description,short_description,sku,regular_price,sale_price,manage_stock,stock_quantity,stock_status,attributes,categories'
            ]);
            
            if(count($products) > 0) {
                Log::info("Syncing {$per_page} products of page {$page}");
                foreach ($products as $product) {
                    // If we have products in the loop, create one
                    $created_product = Product::create([
                        'woocommerce_id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'featured' => $product->featured,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'sku' => $product->sku,
                        'regular_price' => $product->regular_price,
                        'sale_price' => $product->sale_price,
                        'manage_stock' => $product->manage_stock,
                        'stock_quantity' => $product->stock_quantity,
                        'stock_status' => $product->stock_status,
                        'product_status' => $product->status,
                        'attributes' => $product->attributes,
                        'sync_status' => 'synced',
                    ]);
        
                    // Fetch the categories using their tag ids
                    $categoryTagIds = collect($product->categories)->pluck('id');
                    $categories_ids = Category::whereIn('tag_id', $categoryTagIds)->get()->pluck('id');
        
                    // Attach the categories to the newly created product
                    $created_product->categories()->attach($categories_ids);
                }
            }

            $page++;
        }
        while (count($products) > 0);

        // Remove the sync lock
        $syncTransaction = SyncTransaction::where('status', 'running')->latest()->first();
        if($syncTransaction) {
            Log::info("Updating the sync lock to ended");

            $syncTransaction->status = 'ended';
            $syncdata = $syncTransaction->data;
            $syncdata['ended_at'] = now();
            $syncTransaction->data = $syncdata;
            $syncTransaction->save();
        }

        // Notification to admins of a finished sync
        $this->sendFinishedNotification($this->actor);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        // Remove the sync lock
        $syncTransaction = SyncTransaction::where('status', 'running')->latest()->first();
        if($syncTransaction) {
            Log::info("Updating the sync lock to failed");

            $syncTransaction->status = 'failed';
            $syncdata = $syncTransaction->data;
            $syncdata['ended_at'] = now();
            $syncTransaction->data = $syncdata;
            $syncTransaction->save();
        }

        // Notify admins of a failed sync
        $this->sendFailedNotification($this->actor, $exception);
    }

    /**
     * Send finished notification after the job is finished.
     */
    protected function sendFinishedNotification(User $actor)
    {
        $admins = User::role('admin')->get();
        Notification::send($admins, new SyncFinishedNotification($actor));
    }

    /**
     * Send failed notification after the job is finished.
     */
    protected function sendFailedNotification(User $actor, Throwable $exception)
    {
        $admins = User::role('admin')->get();
        Notification::send($admins, new SyncFailedNotification($actor, $exception->getMessage()));
    }
}
