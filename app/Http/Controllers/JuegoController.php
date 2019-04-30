<?php

namespace App\Http\Controllers;

use App\Juego;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function JuegoListarVista()
    {
        return view('Juego.JuegoListarVista');
    }

    public function JuegoEditarVista($IdJuego)
    {
        $juego = Juego::findorfail($IdJuego);
        return view('Juego.JuegoEditarVista', compact('juego'));
    }

    public function JuegoListarJson()
    {
        $lista = "";
        $mensaje = "";
        try {
            $lista = Juego::JuegoListarLapsoJson();
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json([
            'data' => $lista,
            'mensaje' => $mensaje
        ]);
    }

    public function JuegoEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Juego::JuegoEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }


}
