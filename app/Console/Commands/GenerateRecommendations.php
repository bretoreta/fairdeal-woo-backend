<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Laravel\Prompts\Output\ConsoleOutput;

class GenerateRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-recommendations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate product recommendations for the app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('Begining Generating Reccomendations. This may take a while. DO NOT INTERRUPT THIS PROCESS UNTIL DONE');

        $products = Product::all();
        $bar = $this->output->createProgressBar(count($products));

        $bar->start();

        DB::transaction(function() {
            Product::generateRecommendations('sold_together');
            Product::generateRecommendations('similar_products');
        });

        $bar->finish();

        $this->newLine();
        $this->info('Done Generating Reccomendations');

        return 'Done';
    }
}
