<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
{
    protected $fillable = ['ulid', 'barcode', 'order_number', 'part_number', 'sequence', 'standard_pack', 'status'];

    protected static function booted()
    {
        static::creating(function ($material) {
            $material->ulid = Str::ulid();
        });
    }

    public function materialMovements()
    {
        return $this->hasMany(MaterialMovement::class);
    }
}
