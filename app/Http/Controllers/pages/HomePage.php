<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePage extends Controller
{
  public function index()
  {
    $user = auth()->user(); // Obtener el usuario autenticado

    // Obtener los roles asignados al usuario
    $roles = $user->roles;

    // Iterar sobre los roles del usuario
    foreach ($roles as $role) {
        echo $role->name; // Imprimir el nombre del rol
    }
    //dd($roles);
    return view('content.pages.pages-home');
  }
}
