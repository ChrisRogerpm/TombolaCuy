<?php

namespace App\Http\Controllers;

use App\Funciones;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function DashboardVista()
    {
//        return view('Home.DashboardVista');
        $ayer = "2019-05-30 15:12:00";
        $hoy = now();

//        if($ayer<$hoy){
//            echo 'hoy mayor';
//        }else{
//            echo 'ayer mayor';
//        }
        $evento_activo_dia_diferente = \DB::table('evento')
            ->whereDate('fechaEvento','!=',now())
            ->where('estadoEvento',1)
            ->get();
        return $evento_activo_dia_diferente;
    }

    public function GenerarExcel(Request $request)
    {
        $respuesta = "";
        $mensaje_error = "";
        try {
            $respuesta = Funciones::GenerarArchivoExcel($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function GenerarArchivoExcelJackpot(Request $request)
    {
        $respuesta = "";
        $mensaje_error = "";
        try {
            $respuesta = Funciones::GenerarArchivoExcelJackpot($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
}
