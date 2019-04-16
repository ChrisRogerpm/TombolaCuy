<?php

namespace App\Http\Controllers;

use App\ApiApuestaTotal\ValidarApi;
use App\Evento;
use App\Funciones;
use App\ResultadoEvento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function DashboardVista()
    {
        return view('Home.DashboardVista');
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

    public function GenerarArchivoExcelJackpot(Request $request)
    {
        $respuesta = "";
        $mensaje_error = "";
        try {
            $respuesta = Funciones::GenerarArchivoExcelJackpot($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
