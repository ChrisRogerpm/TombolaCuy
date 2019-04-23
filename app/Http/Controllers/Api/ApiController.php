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
            $estadistica = TipoApuesta::EstadisticaUltimosTipoApuesta($IdJuego);
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
            $segundos_agregados = $evento_actual->segBloqueoAntesAnimacion;
            $fecha_animacion = Carbon::parse($fecha_evento_proximo)->subSeconds($segundos_agregados)->toDateTimeString();
            $token = Evento::ValidarTokenAnimacion($evento_actual->idEvento);
            $estado_animacion = false;
            if (now() > $fecha_animacion && now() < $fecha_evento_prox) {
                $estado_animacion = true;
            }
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
                'segBloqueoAntesAnimacion' => $segundos_agregados,
                'puntos_cuy'=> $evento_actual->puntosCuy// $this->generar_posiciones_random()
            ];
            return response()->json([
                'evento' => $array_evento,
                'resultado_evento' => $resultado_evento,
                'estadistica' => $estadistica
            ]);
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
                'segBloqueoAntesAnimacion' => ''
            ];
            return response()->json([
                'evento' => $array_evento,
                'resultado_evento' => $resultado_evento,
                'estadistica' => $estadistica
            ]);
        }
    }

    public function ConfirmacionToken(Request $request)
    {
        $IdEvento = $request->input('IdEvento');
        $token_animacion = $request->input('token');
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
