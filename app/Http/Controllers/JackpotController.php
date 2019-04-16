<?php

namespace App\Http\Controllers;

use App\Jackpot;
use Illuminate\Http\Request;

class JackpotController extends Controller
{
    public function JackpotListarVista()
    {
        return view('Jackpot.JackpotListarVista');
    }

    public function JackpotInsertarVista()
    {
        return view('Jackpot.JackpotInsertarVista');
    }

    public function JackpotEditarVista($idJackpot)
    {
        $Jackpot = Jackpot::findorfail($idJackpot);
        return view('Jackpot.JackpotEditarVista', compact('Jackpot'));
    }


}
