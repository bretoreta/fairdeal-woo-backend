<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'phone',
        'google_review_link',
        'active_promo',
    ];

    protected $casts = [
        'active_promo' => 'boolean'
    ];
    
    public function users () : HasMany {
        return $this->hasMany(User::class);
    }
}
