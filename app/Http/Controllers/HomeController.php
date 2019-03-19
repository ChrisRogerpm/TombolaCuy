<?php

namespace App\Http\Controllers;

use App\Funciones;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function DashboardVista()
    {
        $listar_juegos = Juego::JuegoListarLapsoJson();
        return view('Home.DashboardVista', compact('listar_juegos'));
    }

    public function GenerarExcel(Request $request)
    {
        $respuesta = "";
        $mensaje_error = "";
        try {
            $respuesta = Funciones::GenerarArchivoExcel($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
