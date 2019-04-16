<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AnimacionController extends Controller
{
    public function AnimacionVista()
    {
        return view('Animacion.AnimacionVista');
    }    
}
