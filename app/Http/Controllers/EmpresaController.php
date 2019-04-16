<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function EmpresaListarVista()
    {
        return view('Empresa.EmpresaListarVista');
    }

    public function EmpresaInsertarVista()
    {
        return view('Empresa.EmpresaInsertarVista');
    }

    public function EmpresaEditarVista($idEmpresa)
    {
        $empresa = Empresa::findorfail($idEmpresa);
        return view('Empresa.EmpresaEditarVista', compact('empresa'));
    }

    public function EmpresaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Empresa::EmpresaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function EmpresaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Empresa::EmpresaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function EmpresaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Empresa::EmpresaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

}
