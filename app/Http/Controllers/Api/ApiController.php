<?php

namespace App\Http\Controllers\Api;

use App\Evento;
use App\ResultadoEvento;
use App\TipoApuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function EventoFecha(Request $request)
    {
        $IdJuego = $request->input('IdJuego');
        $evento_actual = Evento::EventoActual($IdJuego);
        $resultado_evento = ResultadoEvento::ResultadosEvento($IdJuego);
        if ($evento_actual != null) {
            $ganador = ResultadoEvento::ValorGanadorEvento($evento_actual->idEvento);
            $estadistica = TipoApuesta::EstadisticaUltimosTipoApuesta();
            $fecha_ini_actual = $evento_actual->fechaEvento;
            $fecha_fin_actual = $evento_actual->fechaFinEvento;
            $fecha_evento_proximo = new Carbon();
            if ($evento_actual->lapsoProxEventoHoras > 0) {
                $NumeroHoras = $evento_actual->lapsoProxEventoHoras;
                $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addHours($NumeroHoras);
            } else if ($evento_actual->lapsoProxEventoMinutos > 0) {
                $NumeroMinutos = $evento_actual->lapsoProxEventoMinutos;
                $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addMinutes($NumeroMinutos);
            }
            $fecha_evento_prox = $fecha_evento_proximo->toDateTimeString();
            $segundos_agregados = $evento_actual->segBloqueoAntesEvento + 20;
            $fecha_animacion = Carbon::parse($fecha_evento_proximo)->subSeconds($segundos_agregados)->toDateTimeString();
            $estado_animacion = false;
            if (now() > $fecha_animacion && now() < $fecha_evento_prox) {
                $estado_animacion = true;
            }
            
            if ($estado_animacion) {
                if ($evento_actual->estadoAnimacion == 0) {
                    $token = Evento::ValidarTokenAnimacion($evento_actual->idEvento);
                    $array_evento = [
                        'token_animacion' => $token,
                        'mensaje_token' => 'Esperando respuesta de token',
                        'estado_animacion' => $estado_animacion,
                        'fecha_evento_ini_actual' => $fecha_ini_actual,
                        'fecha_evento_fin_actual' => $fecha_fin_actual,
                        'fecha_evento_proximo' => $fecha_evento_prox,
                        'fecha_animacion' => $fecha_animacion,
                        'evento_id_actual' => $evento_actual->idEvento,
                        'evento_valor_ganador' => $ganador->valorGanador,
                    ];
                    return response()->json([
                        'evento' => $array_evento,
                        'resultado_evento' => $resultado_evento,
                        'estadistica' => $estadistica
                    ]);
                } else {
                    return response()->json(['mensaje' => 'El estado de animación del evento actual esta activado']);
                }
            } else {
                $array_evento = [
                    'fecha_evento_ini_actual' => $fecha_ini_actual,
                    'fecha_evento_fin_actual' => $fecha_fin_actual,
                    'fecha_evento_proximo' => $fecha_evento_prox,
                    'fecha_animacion' => $fecha_animacion,
                    'evento_id_actual' => $evento_actual->idEvento,
                    'evento_valor_ganador' => $ganador->valorGanador,
                ];
                return response()->json([
                    'mensaje' => 'No se encuentra en el tiempo de rango de Animación',
                    'evento' => $array_evento,
                    'resultado_evento' => $resultado_evento,
                    'estadistica' => $estadistica
                ]);
            }
        } else {
            $estadistica = TipoApuesta::EstadisticaUltimosTipoApuesta();
            $array_evento = [
                'token_animacion' => '',
                'mensaje_token' => '',
                'estado_animacion' => '',
                'fecha_evento_ini_actual' => '',
                'fecha_evento_fin_actual' => '',
                'fecha_evento_proximo' => '',
                'fecha_animacion' => '',
                'evento_id_actual' => '',
                'evento_valor_ganador' => '',
            ];
            return response()->json([
                'evento' => $array_evento,
                'resultado_evento' => $resultado_evento,
                'estadistica' => $estadistica
            ]);
        }
    }

    public function EventoFecha_outValidate(Request $request)
    {
        $IdJuego = $request->input('IdJuego');
        $evento_actual = Evento::EventoActual($IdJuego);
        $resultado_evento = ResultadoEvento::ResultadosEvento($IdJuego);
        if ($resultado_evento != null) {
            if ($evento_actual == null) {
                return response()->json(['mensaje' => 'No se ha encontrado evento alguno']);
            } else {
                $ganador = ResultadoEvento::ValorGanadorEvento($evento_actual->idEvento);
                $estadistica = TipoApuesta::EstadisticaUltimosTipoApuesta();
                $fecha_ini_actual = $evento_actual->fechaEvento;
                $fecha_fin_actual = $evento_actual->fechaFinEvento;
                $fecha_evento_proximo = new Carbon();
                if ($evento_actual->lapsoProxEventoHoras > 0) {
                    $NumeroHoras = $evento_actual->lapsoProxEventoHoras;
                    $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addHours($NumeroHoras);
                } else if ($evento_actual->lapsoProxEventoMinutos > 0) {
                    $NumeroMinutos = $evento_actual->lapsoProxEventoMinutos;
                    $fecha_evento_proximo = Carbon::parse($evento_actual->fechaEvento)->addMinutes($NumeroMinutos);
                }
                $fecha_evento_prox = $fecha_evento_proximo->toDateTimeString();
                $fecha_animacion = Carbon::parse($fecha_evento_proximo)->subSeconds($evento_actual->segBloqueoAntesEvento)->toDateTimeString();
                $estado_animacion = false;
                if (now() > $fecha_animacion && now() < $fecha_evento_prox) {
                    $estado_animacion = true;
                }
                if ($evento_actual->estadoAnimacion == 0) {
                    $token_generado = str_random(8);
                    $token = Evento::ValidarTokenAnimacion($evento_actual->idEvento);
                    if (!empty($token)) {
                        return response()->json([
                            'token_animacion' => $token,
                            'mensaje_token' => 'Esperando respuesta de token',
                            'estado_animacion' => $estado_animacion,
                            'fecha_evento_ini_actual' => $fecha_ini_actual,
                            'fecha_evento_fin_actual' => $fecha_fin_actual,
                            'fecha_evento_proximo' => $fecha_evento_prox,
                            'fecha_animacion' => $fecha_animacion,
                            'evento_id_actual' => $evento_actual->idEvento,
                            'evento_valor_ganador' => $ganador->valorGanador,
                            'resultado_evento' => $resultado_evento,
                            'estadistica' => $estadistica
                        ]);
                    } else {
                        $eventoToken = Evento::EventoTokenAnimacion($token_generado, $evento_actual->idEvento);
                        return response()->json([
                            'token_animacion' => $eventoToken->tokenAnimacion,
                            'mensaje_token' => 'Esperando respuesta de token',
                            'estado_animacion' => $estado_animacion,
                            'fecha_evento_ini_actual' => $fecha_ini_actual,
                            'fecha_evento_fin_actual' => $fecha_fin_actual,
                            'fecha_evento_proximo' => $fecha_evento_prox,
                            'fecha_animacion' => $fecha_animacion,
                            'evento_id_actual' => $evento_actual->idEvento,
                            'evento_valor_ganador' => $ganador->valorGanador,
                            'resultado_evento' => $resultado_evento,
                            'estadistica' => $estadistica
                        ]);
                    }
                } else {
                    return response()->json(['mensaje' => 'El estado de animación del evento actual esta activado', 'estado_animacion' => false]);
                }
            }
        } else {
            return response()->json(['mensaje' => 'El juego ingresado no existe']);
        }
    }

    public function ConfirmacionToken(Request $request)
    {

//        $IdJuego = $request->input('IdJuego');
        $IdEvento = $request->input('IdEvento');
        $token_animacion = $request->input('token');
//        $evento_actual = Evento::EventoActual($IdJuego);
        if ($token_animacion != null) {
            $respuestaValorToken = Evento::CambiarEstadoAnimacionEvento($IdEvento, $token_animacion);
            if ($respuestaValorToken) {
                return response()->json(['mensaje' => 'Se ha cambiado el estado de animacion', 'estado' => true]);
            } else {
                return response()->json(['mensaje' => 'Se ha ingresado un token diferente', 'estado' => false]);
            }
        }
    }
}
