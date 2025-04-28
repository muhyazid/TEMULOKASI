<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuzzyKeanggotaan extends Model
{
    use HasFactory;
    protected $fillable = ['parameter_name', 'label_fuzzy', 'min', 'mid', 'max'];
}
