<?php

namespace App\Http\Controllers;

use App\DineroDefault;
use Illuminate\Http\Request;

class DineroDefaultController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function DineroDefaultListarVista()
    {
        return view('DineroDefault.DineroDefaultListarVista');
    }

    public function DineroDefaultInsertarVista()
    {
        return view('DineroDefault.DineroDefaultInsertarVista');
    }

    public function DineroDefaultEditarVista($idDineroDefault)
    {
        $DineroDefault = DineroDefault::findorfail($idDineroDefault);
        return view('DineroDefault.DineroDefaultEditarVista', compact('DineroDefault'));
    }

    public function DineroDefaultListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = DineroDefault::DineroDefaultListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function DineroDefaultInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            DineroDefault::DineroDefaultInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function DineroDefaultEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            DineroDefault::DineroDefaultEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
