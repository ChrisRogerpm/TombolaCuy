<?php

namespace App\Http\Controllers;

use App\AperturaCaja;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AperturaCajaController extends Controller
{
    public function AperturaCajaListarVista()
    {
        return view('AperturaCaja.AperturaCajaListarVista');
    }

    public function AperturaCajaInsertarVista()
    {

        return view('AperturaCaja.AperturaCajaInsertarVista');
    }

    public function AperturaCajaEditarVista($idAperturaCaja)
    {
        $AperturaCajaant = AperturaCaja::findorfail($idAperturaCaja);
        $AperturaCaja = AperturaCaja::AperturaCajaDatos($idAperturaCaja)[0];
        return view('AperturaCaja.AperturaCajaEditarVista', compact('AperturaCaja'));
    }

    public function AperturaCajaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = AperturaCaja::AperturaCajaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function AperturaCajaListarActiva(Request $request)
    {
        $lista = "";
        $mensaje_error = "";

        try {
            $lista = AperturaCaja::AperturaCajaListarActiva($request->idUsuario);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function AperturaCajaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            AperturaCaja::AperturaCajaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function AperturaCajaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            AperturaCaja::AperturaCajaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function AperturaCajaCerrarFk(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            AperturaCaja::AperturaCajaCerrarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
