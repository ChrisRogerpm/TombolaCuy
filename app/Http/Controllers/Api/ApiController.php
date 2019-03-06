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
        $evento_actual = Evento::EventoActual($IdJuego);
        $resultado_evento = ResultadoEvento::UltimosResultadosEvento($IdJuego);

        if ($evento_actual == null) {
            return response()->json('null');
        } else {
            $fecha_actual = $evento_actual->fechaEvento;
            $fecha_evento_proximo = '';
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
            return response()->json([
                'fecha_evento_actual' => $fecha_actual,
                'fecha_evento_proximo' => $fecha_evento_proximo->toDateTimeString(),
                'fecha_animacion' => $fecha_evento_proximo->subSeconds($evento_actual->segBloqueoAntesEvento)->toDateTimeString(),
                'resultado_evento' => $resultado_evento
            ]);
        }
    }
}
