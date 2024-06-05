<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('simple');
            $table->string('slug');
            $table->string('status');
            $table->boolean('featured')->default(false);
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku');
            $table->string('regular_price');
            $table->string('sale_price')->nullable();
            $table->boolean('manage_stock')->default(false);
            $table->integer('stock_quantity')->nullable();
            $table->string('stock_status');
            $table->jsonb('attributes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
