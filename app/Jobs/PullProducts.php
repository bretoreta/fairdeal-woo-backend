<?php

namespace App\Jobs;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Codexshaper\WooCommerce\Facades\Product as WooCommerceProduct;
use App\Models\Image as ImageModel;
use App\Models\Product;
use App\Models\SyncTransaction;
use App\Models\User;
use App\Notifications\Admin\SyncFailedNotification;
use App\Notifications\Admin\SyncFinishedNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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
            $wooProducts = WooCommerceProduct::all([
                'per_page' => $per_page,
                'page' => $page,
                'fields' => 'id,name,slug,featured,description,short_description,sku,regular_price,sale_price,manage_stock,stock_quantity,stock_status,attributes,categories'
            ]);
            
            if(count($wooProducts) > 0) {
                Log::info("Syncing {$per_page} products of page {$page}");
                foreach ($wooProducts as $wooProduct) {
                    // If we have products in the loop, create one
                    $laravelProduct = Product::create([
                        'woocommerce_id' => $wooProduct->id,
                        'name' => $wooProduct->name,
                        'slug' => $wooProduct->slug,
                        'featured' => $wooProduct->featured,
                        'description' => $wooProduct->description,
                        'short_description' => $wooProduct->short_description,
                        'sku' => $wooProduct->sku,
                        'regular_price' => $wooProduct->regular_price,
                        'sale_price' => $wooProduct->sale_price,
                        'manage_stock' => $wooProduct->manage_stock,
                        'stock_quantity' => $wooProduct->stock_quantity,
                        'stock_status' => $wooProduct->stock_status,
                        'product_status' => $wooProduct->status,
                        'attributes' => $wooProduct->attributes,
                        'sync_status' => 'synced',
                    ]);

                    if(!is_null($wooProduct->images)) {
                        foreach($wooProduct->images as $image) {
                            $response = Http::get($image->src);
                            $downloadedImage = $response->getBody()->getContents();
        
                            $filename = basename($image->src);
                            $path = "product-images/{$wooProduct->sku}/$filename";
                            $src = url("/storage/{$path}");
        
                            Storage::disk('public')->put($path, $downloadedImage);
        
                            ImageModel::create([
                                'user_id' => $this->actor->id,
                                'model_id' => $laravelProduct->id,
                                'model_type' => Product::class,
                                'path' => $path,
                                'src' => $src,
                            ]);
                        }
                    }
        
                    // Fetch the categories using their tag ids
                    $wooCategoryTagIds = collect($wooProduct->categories)->pluck('id');
                    $laravelCategoriesIds = Category::whereIn('tag_id', $wooCategoryTagIds)->get()->pluck('id');
        
                    // Attach the categories to the newly created product
                    $laravelProduct->categories()->attach($laravelCategoriesIds);
                }
            }

            $page++;
        }
        while (count($wooProducts) > 0);

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
