<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['barcode', 'order_number', 'part_number', 'sequence', 'standard_pack', 'status'];
}
