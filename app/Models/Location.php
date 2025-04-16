<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['name', 'type', 'latitude', 'longitude'];

     public function parameters()
    {
        return $this->hasMany(LocationParameter::class);
    }
}
