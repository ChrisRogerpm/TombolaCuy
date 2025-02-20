<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Exports\ReporteApuestaExport;
use App\HistorialAlerta;
use App\Juego;
use App\PuntoVenta;
use App\Reporte;
use App\TipoApuesta;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function ReporteApuestaVista()
    {
        return view('Reportes.ReporteApuestasVista');
    }

    public function ReporteVentaVista()
    {
        return view('Reportes.ReporteVentasVista');
    }

    public function ReporteVentaJuegoVista()
    {
        $juegos = Juego::JuegoListarLapsoJson();
        return view('Reportes.ReporteVentaJuegoVista', compact('juegos'));
    }

    public function ReporteCierraVentaVista()
    {
        return view('Reportes.ReporteCierreCaja');
    }

    public function ReporteHistorialTicketVista()
    {
        return view('Reportes.ReporteHistorialTickets');
    }

    public function ReporteAuditoriaVista()
    {
        return view('Seguridad.Auditoria');
    }

    public function ReporteAlertasVista()
    {
        return view('Reportes.ReporteAlertasVista');
    }


    public function ReporteHistorialAlertaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = HistorialAlerta::HistorialAlertaListar($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
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
        $lista_tipo_apuesta = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteHistorialGanadoresListarJson($request);
            $lista_tipo_apuesta = TipoApuesta::TipoApuestaListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'lista_tipo_apuesta' => $lista_tipo_apuesta, 'mensaje' => $mensaje_error]);
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
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);

    }

    public function ReporteVentaJson(Request $request)
    {
        $lista = "";
        $respuesta = false;
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteVenta($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ReporteVentaJuegoJson(Request $request)
    {
        $lista = "";
        $respuesta = false;
        $lista_apuestas = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteVentaJuego($request);
            $lista_apuestas = TipoApuesta::TipoApuestaListar();
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'data' => $lista, 'data_apuestas' => $lista_apuestas, 'mensaje' => $mensaje_error]);
    }

    public function ReporteCierreCajaFk()
    {
        $data = "";
        $mensaje = "";
        try {
            $data = Reporte::ReporteCierreCaja();
        } catch (QueryException $ex) {
            $mensaje = $ex->errorInfo;
        }
        return response()->json(['data' => $data, 'mensaje' => $mensaje]);
    }

    public function ReporteHistorialTicketJson(Request $request)
    {
        $lista = "";
        $respuesta = false;
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteHistorialTicket($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ReporteAuditoriaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Reporte::ReporteAuditoriaListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function ObtenerPuntosVentaZonaComercialJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaZonaListarUsuarioJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

}
