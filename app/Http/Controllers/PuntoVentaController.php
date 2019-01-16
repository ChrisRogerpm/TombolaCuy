<?php

namespace App\Http\Controllers;

use App\PuntoVenta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function PuntoVentaListarVista()
    {
        return view('PuntoVenta.PuntoVentaListarVista');
    }

    public function PuntoVentaInsertarVista()
    {
        return view('PuntoVenta.PuntoVentaInsertarVista');
    }

    public function PuntoVentaEditarVista($idPuntoVenta)
    {
        $PuntoVenta = PuntoVenta::findorfail($idPuntoVenta);
        return view('PuntoVenta.PuntoVentaEditarVista', compact('PuntoVenta'));
    }

    public function PuntoVentaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function PuntoVentaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            PuntoVenta::PuntoVentaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function PuntoVentaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            PuntoVenta::PuntoVentaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
