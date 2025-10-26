<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'table_number', 'status', 'total_amount', 'user_id'];

    // Relationship with order items
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship with user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}