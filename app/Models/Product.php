<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'woocommerce_id',
        'name',
        'slug',
        'featured',
        'description',
        'short_description',
        'sku',
        'regular_price',
        'sale_price',
        'manage_stock',
        'stock_quantity',
        'stock_status',
        'attributes',
        'sync_status',
    ];

    protected $casts = [
        'attributes' => 'array',
        'images' => 'array',
    ];

    public function categories () : BelongsToMany {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images(): MorphMany {
        return $this->morphMany(Image::class, 'model');
    }
}
