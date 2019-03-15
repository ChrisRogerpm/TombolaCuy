<?php

namespace App\Http\Controllers\Api;

use App\Evento;
use App\ResultadoEvento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function EventoFecha(Request $request)
    {
//        $IdJuego = $request->input('IdJuego');
        $IdJuego = 2;
//        $token_animacion = $request->input('token');
        $token_animacion = "qwJ27ymo";
        $evento_actual = Evento::EventoActual($IdJuego);
        $resultado_evento = ResultadoEvento::ResultadosEvento($IdJuego);
        if ($evento_actual == null) {
            return response()->json('null');
        } else {
            $ganador = ResultadoEvento::ValorGanadorEvento($evento_actual->idEvento);
            $fecha_actual = $evento_actual->fechaEvento;

            $fecha_evento_proximo = new Carbon();

            if ($evento_actual->lapsoProxEventoHoras > 0) {
                $NumeroHoras = $evento_actual->lapsoProxEventoHoras;
                $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addHours($NumeroHoras);
            } else if ($evento_actual->lapsoProxEventoDia > 0) {
                $NumeroDias = $evento_actual->lapsoProxEventoDia;
                $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addDays($NumeroDias);
            } else if ($evento_actual->lapsoProxEventoMinutos > 0) {
                $NumeroMinutos = $evento_actual->lapsoProxEventoMinutos;
                $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addMinutes($NumeroMinutos);
            }
//            $fecha_evento_prox = $fecha_evento_proximo->toDateTimeString();
//            $fecha_animacion = $fecha_evento_proximo->subSeconds($evento_actual->segBloqueoAntesEvento)->toDateTimeString();

            $estado_animacion = false;

            $fecha_animacion = "2019-03-15 15:57:00";
            $fecha_evento_prox = "2019-03-15 18:58:00";

            if (now() > $fecha_animacion && now() < $fecha_evento_prox) {
                $estado_animacion = true;
            }
            if ($estado_animacion) {
                if($evento_actual->estadoAnimacion == 0){
                    $token_generado = str_random(8);

                    if($token_animacion != null){
                        $respuestaValorToken = Evento::CambiarEstadoAnimacionEvento($evento_actual->idEvento,$token_animacion);
                    }


                    $token = Evento::ValidarTokenAnimacion($evento_actual->idEvento);
                    if(!empty($token)){
                        return response()->json([
                            'fecha_evento_actual' => $fecha_actual,
                            'fecha_evento_proximo' => $fecha_evento_prox,
                            'fecha_animacion' => $fecha_animacion,
                            'evento_id_actual' => $evento_actual->idEvento,
                            'evento_valor_ganador' => $ganador->valorGanador,
                            'estado_animacion' => $estado_animacion,
                            'token_animacion' => $token,
                            'resultado_evento' => $resultado_evento
                        ]);
                    }else{
                        $eventoToken = Evento::EventoTokenAnimacion($token_generado,$evento_actual->idEvento);
                        return response()->json([
                            'fecha_evento_actual' => $fecha_actual,
                            'fecha_evento_proximo' => $fecha_evento_prox,
                            'fecha_animacion' => $fecha_animacion,
                            'evento_id_actual' => $evento_actual->idEvento,
                            'evento_valor_ganador' => $ganador->valorGanador,
                            'estado_animacion' => $estado_animacion,
                            'token_animacion' => $eventoToken,
                            'resultado_evento' => $resultado_evento
                        ]);
                    }
                }else{
                    return response()->json('null');
                }

            } else {
                return response()->json(['data' => true]);
            }


        }
    }
}
