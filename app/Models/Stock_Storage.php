<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Storage extends Model
{
    protected $table = 'stock_storage';
    protected $fillable = ['name', 'category', 'base_quantity', 'price'];
}
