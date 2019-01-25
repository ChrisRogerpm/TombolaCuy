<?php

namespace App\Http\Controllers;

use App\Reporte;

use App\TipoApuesta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class ReporteController extends Controller
{
    public function ReporteApuestaVista()
    {
        return view('Reportes.ReporteApuestasVista');
    }

    public function ReporteApuestaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteApuestaJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    //REPORTE HISTORIAL DE GANADORES
    public function ReporteHistorialGanadoresVista()
    {
        return view('Reportes.ReporteHistorialGanadoresVista');
    }
    
    public function ReporteHistorialGanadoresListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TipoApuesta::TipoApuestaListarJson();
            
            //$lista = DB::table('tipo_apuesta')->get();
            

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}
