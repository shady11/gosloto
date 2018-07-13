<?php

namespace App\Http\Controllers\Bashkaruu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
    	return view('bashkaruu.index', []);
    }
}
