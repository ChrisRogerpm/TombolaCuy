<?php

namespace App\Http\Controllers;

use App\Exports\ReporteApuestaExport;
use App\Reporte;
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

    public function ReporteHistorialGanadoresListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteHistorialGanadoresListarJson($request);

            //$lista = DB::table('tipo_apuesta')->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    //REPORTE HISTORIAL DE JackPot
    public function ReporteJackPotVista()
    {
        return view('Reportes.ReporteJackPotVista');
    }

    public function ReporteJackPotListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteJackPotListarJson($request);

            //$lista = DB::table('tipo_apuesta')->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    public function ConfiguracionPozoSegunConfJackPot(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ConfiguracionPozoSegunConfJackPot($request);

            //$lista = DB::table('tipo_apuesta')->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    public function PozoJackPotSegunJackPotId(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::PozoJackPotSegunJackPotId($request);

            //$lista = DB::table('tipo_apuesta')->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    public function JackPotSegunidJackpot(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::JackPotSegunidJackpot($request);

            //$lista = DB::table('tipo_apuesta')->get();

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

}
