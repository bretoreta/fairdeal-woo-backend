<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\SyncTransaction;
use App\Models\User;
use App\Notifications\Admin\SyncFailedNotification;
use App\Notifications\Admin\SyncFinishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Codexshaper\WooCommerce\Facades\Category as WooCommerceCategory;
use Illuminate\Support\Facades\Notification;
use Throwable;

class PullCategories implements ShouldQueue
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
            $wooCategories = WooCommerceCategory::all([
                'per_page' => $per_page,
                'page' => $page,
            ]);

            if(count($wooCategories) > 0) {
                foreach ($wooCategories as $category) {
                    Category::create([
                        'tag_id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'parent_id' => $category->parent,
                        'description' => $category->description,
                        'display' => $category->display,
                    ]);
                }
            }

            $page++;
        }
        while (count($wooCategories) > 0);


        $syncTransaction = SyncTransaction::where('status', 'running')->latest()->first();
        if($syncTransaction) {
            $syncTransaction->status = 'ended';
            $syncdata = $syncTransaction->data;
            $syncdata['ended_at'] = now();
            $syncTransaction->data = $syncdata;
            $syncTransaction->save();
        }

        $this->sendFinishedNotification($this->actor);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $syncTransaction = SyncTransaction::where('status', 'running')->latest()->first();
        if($syncTransaction) {
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
