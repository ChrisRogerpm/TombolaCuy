<?php

namespace App\Http\Controllers;
use App\AperturaCaja;
use App\ConfiguracionEvento;
use App\Evento;

use Illuminate\Http\Request;

class VentaController extends Controller
{
     public function Index()
    {
        return view('Venta.Index');
    }


     public function VentaDatosJson()
    {

        $usuario=1;
        $lista = "";
        $mensaje_error = "";
        try {
              $hora_servidor=date('Y-m-d H:i:s');
              $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
              $eventos = Evento::EventoListar();
              $dinerodefault=Evento::DineroDefaultListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                                'hora_servidor'=> $hora_servidor,
                                //'jugador' => $jugador,
                                'aperturacajadatos' => $aperturacajadatos,
                                 'eventos'=>$eventos,
                                 'dinerodefault'=>$dinerodefault,
                                  'mensaje' => $mensaje_error]);
    }

    public function EventoDatosJson(Request $request){
        $mensaje_error = "";
        $idEvento= $request->input("idEvento");
      $idPuntoVenta= $request->input("idPuntoVenta");
        try {
              $hora_servidor=date('Y-m-d H:i:s');
              $jugador = Evento::CantidadGanadorEventoListar($idEvento)[0];
              $divisa = Evento::SimboloEvento($idEvento)[0];
              $jackpots=Evento::JackPotEvento($idPuntoVenta);
              $jackpotsuma=Evento::JackPotSumaEvento($idPuntoVenta)[0];
              $eventodatos = Evento::EventoId($idEvento)[0];

              $tipoapuesta=Evento::TipoApuestaListar();
              $dinerodefault=Evento::DineroDefaultListar();


        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                                'eventodatos'=> $eventodatos,

                                'hora_servidor'=> $hora_servidor,
                                'jugador' => $jugador->cantidadganadores,
                                'divisa'=>$divisa->simbolo,
                                'jackpots'=>$jackpots,
                                'jackpotsuma'=>$jackpotsuma->sumajackpots,
                                'tipoapuesta'=>$tipoapuesta,
                                'dinerodefault'=>$dinerodefault,
                                  'mensaje' => $mensaje_error]);

    }

 public function JackpotDatosJson(Request $request){
        $mensaje_error = "";
      $idPuntoVenta= $request->input("idPuntoVenta");
        try {
              $hora_servidor=date('Y-m-d H:i:s');
              $jackpots=Evento::JackPotEvento($idPuntoVenta);
              $jackpotsuma=Evento::JackPotSumaEvento($idPuntoVenta)[0];


        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                                'hora_servidor'=> $hora_servidor,
                                'jackpots'=>$jackpots,
                                'jackpotsuma'=>$jackpotsuma->sumajackpots,
                                  'mensaje' => $mensaje_error]);

    }

     public function HistorialDatosJson(){
        $mensaje_error = "";
        try {
              $historial = Evento::HistorialEvento();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                                'historial'=> $historial,
                                  'mensaje' => $mensaje_error]);

    }

}
