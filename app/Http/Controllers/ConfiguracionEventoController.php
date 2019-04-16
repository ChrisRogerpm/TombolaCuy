<?php

namespace App\Http\Controllers;

use App\ConfiguracionGenerarEvento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConfiguracionEventoController extends Controller
{
    public function ConfiguracionEventoVista()
    {
        return view('ConfiguracionEvento.ConfiguracionEventoVista');
    }

    public function ConfiguracionEventoMostrar()
    {
        $data = "";
        $mensaje = "";
        try {
            $data = ConfiguracionGenerarEvento::ObtenerConfiguracionGenerarEvento();
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['data' => $data, 'mensaje' => $mensaje]);
    }

    public function ConfiguracionEventoInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try {
            ConfiguracionGenerarEvento::ConfiguracionGenerarEventoInsertar($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }
}
