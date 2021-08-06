<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }
}
