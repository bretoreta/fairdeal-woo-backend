<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];
}
