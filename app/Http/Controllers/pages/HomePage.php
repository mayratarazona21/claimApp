<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePage extends Controller
{
  public function index()
  {
    return view('content.pages.pages-home');
  }
}
