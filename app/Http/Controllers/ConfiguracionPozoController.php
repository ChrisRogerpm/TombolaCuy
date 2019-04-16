<?php

namespace App\Http\Controllers;

use App\ConfiguracionPozo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConfiguracionPozoController extends Controller
{
    public function ConfiguracionPozoListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = ConfiguracionPozo::ConfiguracionPozoListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ConfiguracionPozoEliminarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            ConfiguracionPozo::ConfiguracionPozoEliminarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function CambiarEstadoConfiguracionPozoJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            ConfiguracionPozo::CambiarEstadoConfiguracionPozoJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
