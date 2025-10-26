<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory'; // Specify the table name
    
    protected $fillable = ['name', 'quantity', 'price', 'min_stock_level', 'category', 'unit'];
}