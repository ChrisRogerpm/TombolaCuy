<?php

namespace App\Http\Controllers;

use App\Juego;

class HomeController extends Controller
{
    public function DashboardVista()
    {
        $listar_juegos = Juego::JuegoListarLapsoJson();
        return view('Home.DashboardVista',compact('listar_juegos'));
    }
}
