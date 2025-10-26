<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'table_number', 'status', 'total_amount', 'user_id'];

    // Fix the relationship - dapat 'user' not 'users'
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}