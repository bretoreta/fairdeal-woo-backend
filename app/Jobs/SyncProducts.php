<?php

namespace App\Jobs;

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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SyncProducts implements ShouldQueue
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
        // Retrieve chunks of products
        Product::where('sync_status', 'notsynced')->chunk(100, function(Collection $products) {
            foreach ($products as $product) {

                // If we have a WooCommerce id, update the product.
                if($product->woocommerce_id) {
                    Log::info("Updating product with woo ID: {$product->woocommerce_id}");

                    WooCommerceProduct::update($product->woocommerce_id, [
                        'type' => 'simple',
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'featured' => $product->featured,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'regular_price' => $product->regular_price,
                        'sale_price' => $product->sale_price,
                        'manage_stock' => $product->manage_stock,
                        'stock_quantity' => $product->stock_quantity,
                        'stock_status' => $product->stock_status,
                        'attributes' => $product->attributes,
                    ]);

                }
                
                // Else, create a new product
                else {
                    $woo_product = WooCommerceProduct::create([
                        'type' => 'simple',
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
                        'attributes' => $product->attributes,
                    ]);
                    
                    Log::info("Created product with woo ID: {$product->woocommerce_id}");
                    $product->woocommerce_id = $woo_product['id'];
                    // TODO: Implement a feature to also sync images for the newly created product
                }

                // Update the product status to synced
                $product->sync_status = 'synced';
                $product->save();
            }
        });

        Log::info("Sending Finished Sync Notifications to Admins");
        
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

        // Notify admins of a sync finished
        $this->sendFinishedNotification($this->actor);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::info("Sending Failed Sync Notifications to Admins");
        
        $syncTransaction = SyncTransaction::where('status', 'running')->latest()->first();      
        if($syncTransaction) {
            Log::info("Updating the sync lock to failed");
            $syncTransaction->status = 'failed';
            $syncdata = $syncTransaction->data;
            $syncdata['ended_at'] = now();
            $syncTransaction->data = $syncdata;
            $syncTransaction->save();
        }

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
