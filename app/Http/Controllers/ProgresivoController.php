<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgresivoController extends Controller
{
    public function ProgresivoListarVista()
    {
        return view('Progresivo.ProgresivoListarVista');
    }

    public function ProgresivoInsertarVista()
    {
        return view('Progresivo.ProgresivoInsertarVista');
    }

    public function ProgresivoConfiguracionVista()
    {
        return view('Progresivo.ProgresivoConfiguracionVista');
    }
}
