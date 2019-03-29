<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function CajaListarVista()
    {
        return view('Caja.CajaListarVista');
    }

    public function CajaInsertarVista()
    {
        return view('Caja.CajaInsertarVista');
    }

    public function CajaEditarVista($idCaja)
    {
        $Caja = Caja::findorfail($idCaja);
        return view('Caja.CajaEditarVista', compact('Caja'));
    }

    public function CajaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Caja::CajaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function CajaPuntoVentaUsuarioJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Caja::CajaPuntoVentaUsuario();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function CajaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Caja::CajaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function CajaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Caja::CajaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
    
}
