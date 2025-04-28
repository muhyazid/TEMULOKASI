<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationParameter extends Model
{
    use HasFactory;
    protected $fillable = ['location_id', 'business_type', 'parameter_name', 'value', 'nilai_crisp'];
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
