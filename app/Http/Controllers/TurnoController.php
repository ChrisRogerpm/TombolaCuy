<?php

namespace App\Http\Controllers;

use App\Turno;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function TurnoListarVista()
    {
        return view('Turno.TurnoListarVista');
    }

    public function TurnoInsertarVista()
    {
        return view('Turno.TurnoInsertarVista');
    }

    public function TurnoEditarVista($idTurno)
    {
        $Turno = Turno::findorfail($idTurno);
        return view('Turno.TurnoEditarVista', compact('Turno'));
    }

    public function TurnoListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Turno::TurnoListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function TurnoInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Turno::TurnoInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function TurnoEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            Turno::TurnoEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
