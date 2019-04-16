<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function ClienteListarVista()
    {
        return view('Cliente.ClienteListarVista');
    }

    public function ClienteInsertarVista()
    {
        return view('Cliente.ClienteInsertarVista');
    }

    public function ClienteEditarVista($idCliente)
    {
        $Cliente = Cliente::findorfail($idCliente);
        return view('Cliente.ClienteEditarVista', compact('Cliente'));
    }

    public function ClienteListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Cliente::ClienteListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ClienteInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Cliente::ClienteInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function ClienteEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Cliente::ClienteEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
