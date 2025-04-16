<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    public function index()
    {
        return view('pages.admin.manajemen-user');
    }
}
