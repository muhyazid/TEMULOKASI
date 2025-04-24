<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinguistikNilai extends Model
{
    use HasFactory;
    protected $table = 'linguistik_nilai';
    protected $fillable = ['parameter_name', 'label_linguistik', 'nilai_crisp'];
}
