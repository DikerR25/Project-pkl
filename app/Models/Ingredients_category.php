<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients_category extends Model
{
    protected $table = 'ingredients_category';
    protected $primaryKey = 'id';
    protected $fillable = ['category'];
}
