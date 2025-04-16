<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HasilRekomendasiController extends Controller
{
    public function index(){
        return view('pages.user.hasil-rekomendasi');
    }
}
