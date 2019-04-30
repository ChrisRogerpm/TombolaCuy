<?php

namespace App\Http\Controllers;

use App\ConfiguracionGeneral;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConfiguracionGeneralController extends Controller
{
    public function ConfiguracionGeneralVista()
    {
        return view('ConfiguracionGeneral.ConfiguracionGeneral');
    }

    public function ConfiguracionEventoMostrar()
    {
        $data = "";
        $mensaje = "";
        try {
            $data = ConfiguracionGeneral::ObtenerConfiguracionEvento();
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
            ConfiguracionGeneral::ConfiguracionEventoInsertar($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }

    public function ConfiguracionCobrarTicketJson(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try {
            ConfiguracionGeneral::ConfiguracionCobrarTicket($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }

    public function ConfiguracionCuentaCorreoJson(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try {
            ConfiguracionGeneral::ConfiguracionCuentaCorreo($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }
}
