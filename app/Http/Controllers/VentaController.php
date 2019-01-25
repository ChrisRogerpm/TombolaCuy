<?php

namespace App\Http\Controllers;
use App\AperturaCaja;
use App\ConfiguracionEvento;

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
              $eventos = ConfiguracionEvento::EventoListar();
              //$configuracioneventos = ConfiguracionEvento::ConfiguracionEventoListar($usuario);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                                'hora_servidor'=> $hora_servidor,
                                //'jugador' => $jugador,
                                'aperturacajadatos' => $aperturacajadatos,
                                 'eventos'=>$eventos,
                                  'mensaje' => $mensaje_error]);
    }


}
