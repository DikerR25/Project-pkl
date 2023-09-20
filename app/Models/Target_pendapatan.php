<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target_pendapatan extends Model
{
    protected $table = 'target_penjualan';
    protected $primaryKey = 'id';
    protected $fillable = ['key', 'tujuan_penghasilan'];
}

