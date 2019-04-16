<?php

namespace App\Http\Controllers;

use App\PuntoVenta;
use App\Usuario;
use App\UsuarioPuntoVenta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UsuarioPuntoVentaController extends Controller
{
    public function UsuarioPuntoVentaListarVista()
    {
        return view('UsuarioPuntoVenta.UsuarioPuntoVentaListarVista');
    }

    public function UsuarioPuntoVentaInsertarVista()
    {
        return view('UsuarioPuntoVenta.UsuarioPuntoVentaInsertarVista');
    }

    public function UsuarioPuntoVentaEditarVista($idUsuarioPuntoVenta)
    {
        $UsuarioPuntoVenta = Usuario::where('idUsuario', $idUsuarioPuntoVenta)->first();
        return view('UsuarioPuntoVenta.UsuarioPuntoVentaEditarVista', compact('UsuarioPuntoVenta'));
    }

    public function UsuarioPuntoVentaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = UsuarioPuntoVenta::UsuarioPuntoVentaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function UsuarioPuntoVentaListaObtener(Request $request)
    {
        $lista = "";
        $lista_punto_venta_obtener = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaListarJson();
            $lista_punto_venta_obtener = UsuarioPuntoVenta::UsuarioPuntoVentaObtener($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'lista_obtener' => $lista_punto_venta_obtener, 'mensaje' => $mensaje_error]);
    }

    public function UsuarioPuntoVentaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            UsuarioPuntoVenta::UsuarioPuntoVentaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function UsuarioPuntoVentaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            UsuarioPuntoVenta::UsuarioPuntoVentaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function AgregarPuntoVentaUsuarioJson(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try{
            UsuarioPuntoVenta::AgregarPuntoVentaUsuario($request);
            $respuesta = true;
        }catch (QueryException $ex){
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }
    public function QuitarPuntoVentaUsuarioJson(Request $request)
    {
        $respuesta = false;
        $mensaje = "";
        try{
            UsuarioPuntoVenta::QuitarPuntoVentaUsuario($request);
            $respuesta = true;
        }catch (QueryException $ex){
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
    }
}
