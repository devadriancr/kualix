<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description'];

    public function areas()
    {
        return $this->hasMany(Area::class, 'department_id');
    }
}
