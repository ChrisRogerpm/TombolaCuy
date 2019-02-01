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
    public function ExportarExcel(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        // try {
        // $data = Reporte::ReporteApuestaJson($request);
            $result = array();
            foreach ($data as $key => $value) {
                $result[] = ['Tienda' => $value->Tienda, 'Evento' => $value->Evento, 'Apuestas' => $value->Apuestas, 'Pagos' => $value->Pagos, 'Jugadores' => $value->Jugadores];
            }
        //     Excel::create('ReporteApuesta', function ($excel) use ($result) {
        //         $excel->sheet('Sheet 1', function ($sheet) use ($result) {
        //             $sheet->fromArray($result);
        //         });
        //     })->export('xls');
        // } catch (QueryException $ex) {

        // }
        // return back();
        return (new ReporteApuestaExport($tiendas,$fechaIni,$fechaFin))->download('invoices.xlsx');
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


}
