<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients_category_sale extends Model
{
    protected $table = 'ingredients_category_sale';
    protected $primaryKey = 'id';
    protected $fillable = ['category'];
}
