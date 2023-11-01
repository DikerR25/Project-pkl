<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $fillable = ['requirement', 'category', 'price', 'unit_price','quantity'];
    public $timestamps = true;
}
