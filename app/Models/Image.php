<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'file_name',
        'mime_type',
        'file_size',
        'full_size_url',
        'thumbnail_size_url',
        'medium_size_url',
    ];

    protected static function boot() {
        parent::boot();
    
        // Generate a UUID during model creation
        static::creating(function ($image) {
            $image->uuid = Str::orderedUuid();
        });
    }

    public function model() : MorphTo
    {
        return $this->morphTo();
    }
}