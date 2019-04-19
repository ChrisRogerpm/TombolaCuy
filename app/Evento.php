<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Evento extends Model
{
    protected $table = 'evento';

    protected $primaryKey = 'idEvento';

    protected $fillable = [
        'idJuego',
        'nombre',
        'fechaEvento',
        'fechaFinEvento',
        'apuestaMinima',
        'apuestaMaxima',
        'fechaEventoReprogramacion',
        'idMoneda',
        'estadoEvento',
        'estadoAnimacion',
        'tokenAnimacion'
    ];

    public $timestamps = false;

    public static function EventoListar()
    {
        $listar = DB::select(DB::raw('
select ev.idEvento,ev.idJuego,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1'));
        return $listar;
    }

    public static function EventoDatosListar($idPuntoVenta)
    {
        $listar = DB::select(DB::raw('
 select 
(select  COUNT(*)  as cantidadganadores FROM ticket WHERE idEvento=ev.idEvento) as jugador,
(select mon.simbolo as simbolo  FROM evento ev2 left join moneda mon on mon.idMoneda=ev2.idMoneda WHERE ev2.idEvento=ev.idEvento ) as divisa,
(select   IFNULL(sum(POL.montoActual),0) as sumajackpots FROM pozo_online POL
            INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
            INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
            INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
            WHERE JPV.idPuntoVenta= ' . $idPuntoVenta . ') as jackpotsuma,
ev.idEvento,ev.idJuego,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1 and ju.estado=1'));
        return $listar;
    }


    public static function EventoId($idEvento)
    {

        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento, ju.logo as logo,
            ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1 and idEvento=' . $idEvento));
        return $listar;
    }

    public static function CantidadGanadorEventoListar($idEvento)
    {
        $listar = DB::select(DB::raw("select  COUNT(*)  as cantidadganadores FROM ticket WHERE idEvento =" . $idEvento));
        return $listar;
    }

    public static function SimboloEvento($idEvento)
    {
        $listar = DB::select(DB::raw("select mon.simbolo as simbolo  FROM evento ev left join moneda mon on mon.idMoneda=ev.idMoneda WHERE IDEVENTO =" . $idEvento));
        return $listar;
    }

    public static function JugadorDatosJson($idEvento)
    {
        $listar = DB::select(DB::raw("select  POL.montoActual FROM pozo_online POL
            INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
            INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
            INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
            WHERE JPV.idPuntoVenta=1
            "));
        return $listar;
    }

    public static function JackPotEvento($idPuntoVenta)
    {
        $listar = DB::select(DB::raw("select  POL.montoActual FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=" . $idPuntoVenta . "
			"));
        return $listar;
    }

    public static function JackPotSumaEvento($idPuntoVenta)
    {
        $listar = DB::select(DB::raw("select   IFNULL(sum(POL.montoActual),0) as sumajackpots FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=" . $idPuntoVenta . "
			"));
        return $listar;
    }


    public static function HistorialEvento($ideventoactual)
    {
        $listar = DB::select(DB::raw("select evt.idEvento, res.`valorGanador`,tipo_apuesta.rgb as color
         FROM  `resultado_evento` res
inner join evento evt on res.`idEvento`=evt.`idEvento`
left join tipo_apuesta on tipo_apuesta.idTipoApuesta=res.idTipoApuesta
WHERE  
 evt.idJuego=(select even.idJuego from evento as even where even.idEvento=".$ideventoactual.")

and (tipo_apuesta.idTipoPago in (1,6) ) 
and evt.idEvento!=" . $ideventoactual . " 
order by evt.`fechaEvento` DESC
LIMIT 18
            "));
        return $listar;
    }

    public static function TipoApuestaListar()
    {
        $listar = DB::select(DB::raw("
        select tip_apu.valorapuesta,
 tip_apu.idTipoApuesta ,
 tip_apu.nombre,
 tip_apu.rgb, 
 FLOOR(tip_pag.multiplicadorDefecto) as multiplicadorDefecto,
  tip_pag.idTipoPago,
 tip_pag.plenoMinimo,
 tip_pag.plenoMaximo,tip_pag.intercalado
  from tipo_apuesta tip_apu LEFT JOIN tipo_pago tip_pag on tip_pag.idTipopago= tip_apu.idTipoPago"));
        return $listar;
    }

    public static function DineroDefaultListar()
    {
        $listar = DB::select(DB::raw("select * from dinero_default where estado =1"));
        return $listar;
    }

    public static function RegistrarEvento($juego, $fechaEventoFin, $fechaIni)
    {
        $token_generado = str_random(8);
        $evento = new Evento();
        $evento->idJuego = $juego->idJuego;
        $evento->nombre = $juego->nombre;
        $evento->fechaEvento = $fechaIni;
        $evento->fechaFinEvento = $fechaEventoFin;
        $evento->apuestaMinima = $juego->apuestaMinima;
        $evento->apuestaMaxima = $juego->apuestaMaxima;
        $evento->idMoneda = $juego->idMoneda;
        $evento->estadoEvento = 0;
        $evento->estadoAnimacion = 0;
        $evento->tokenAnimacion = $token_generado;
        $evento->save();
        return $evento;
    }

    //public static function
    public static function GenerarEventoJob()
    {
        $ListaJuego = Juego::JuegoListarLapsoJson();
        foreach ($ListaJuego as $juego) {
            $JuegoEvento = Juego::JuegoEventoEjecucion($juego->idJuego);
            if ($JuegoEvento != null) {
                if (now() >= $JuegoEvento->fechaFinEvento) {
                    $respuesta = Juego::ActualizarEventoEjecucion($JuegoEvento->idEvento);
                    if ($respuesta) {
                        $Evento_creado = "";
                        if ($juego->lapsoProxEventoHoras > 0) {
                            $NumeroHoras = $juego->lapsoProxEventoHoras;
                            $fechaIni = $JuegoEvento->fechaFinEvento;
                            $fechaFin = Carbon::parse($JuegoEvento->fechaFinEvento)->addHours($NumeroHoras);
                            $Evento_creado = Evento::RegistrarEvento($juego, $fechaFin, $fechaIni);
                        } else if ($juego->lapsoProxEventoMinutos > 0) {
                            $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                            $fechaIni = $JuegoEvento->fechaFinEvento;
                            $fechaFin = Carbon::parse($JuegoEvento->fechaFinEvento)->addMinutes($NumeroMinutos);
                            $Evento_creado = Evento::RegistrarEvento($juego, $fechaFin, $fechaIni);
                        }
                        $numero_random = rand(0, 36);
                        TipoApuesta::TipoApuestaColor($numero_random, $Evento_creado->idEvento);
                    }
                }
            } else {
                //crear evento desde 0
                $Evento_creado = "";
                if ($juego->lapsoProxEventoHoras > 0) {
                    $NumeroHoras = $juego->lapsoProxEventoHoras;
                    $fecha = now()->addHours($NumeroHoras);
                    $Evento_creado = Evento::RegistrarEvento($juego, $fecha, now());
                } else if ($juego->lapsoProxEventoMinutos > 0) {
                    $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                    $fecha = now()->addMinutes($NumeroMinutos);
                    $Evento_creado = Evento::RegistrarEvento($juego, $fecha, now());
                }
                $numero_random = rand(0, 24);
                TipoApuesta::TipoApuestaColor($numero_random, $Evento_creado->idEvento);
            }
        }
    }

    public static function EventoActual($IdJuego)
    {
        $resultado = DB::table('evento as e')
            ->join('juego as j', 'j.idJuego', 'e.idJuego')
            ->where('e.idJuego', $IdJuego)
            ->where('estadoEvento', 1)
            ->first();
        return $resultado;
    }

    public static function CambiarEstadoAnimacionEvento($IdEvento, $token_animacion)
    {

        $resultado = false;
        $respuesta = DB::table('evento')
            ->where('idEvento', $IdEvento)
            ->where('tokenAnimacion', $token_animacion)
            ->first();

        if ($respuesta != null) {
            try {
                $evento = Evento::findorfail($IdEvento);
                $evento->estadoAnimacion = 1;
                $evento->save();
                $resultado = true;
            } catch (QueryException $ex) {
            }
        }
        return $resultado;
    }

    public static function EventoTokenAnimacion(string $token_generado, $idEvento)
    {
        $evento = "";
        try {
            $evento = Evento::findorfail($idEvento);
            $evento->tokenAnimacion = $token_generado;
            $evento->save();
        } catch (QueryException $ex) {
        }

        return $evento;
    }

    public static function ValidarTokenAnimacion($idEvento)
    {
        $token = "";
        $evento = Evento::findorfail($idEvento);
        if ($evento->tokenAnimacion != "") {
            $token = $evento->tokenAnimacion;
        }
        return $token;
    }

    public static function ObtenerUltimoEvento($idJuego, $fechaIni, $fechaFin)
    {
        $resultado = DB::table('evento as e')
            ->where('e.idJuego', $idJuego)
            ->whereBetween('e.fechaEvento', array($fechaIni, $fechaFin))
            ->orderBy('idEvento', 'desc')
            ->first();
        return $resultado;
    }

    public static function GenerarEventoJobNuevo()
    {
        $Configuracion = DB::table('configuracion_generar_evento')
            ->first();
        if ($Configuracion != null) {
            $fecha_inicio = today()->toDateString() . ' ' . $Configuracion->HoraInicioIntervalo;
            $fecha_fin = today()->toDateString() . ' ' . $Configuracion->HoraFinIntervalo;
        } else {
            $fecha_inicio = today()->startOfDay()->toDateTimeString();
            $fecha_fin = today()->endOfDay()->toDateTimeString();
        }
        while ($fecha_inicio <= $fecha_fin) {
            $respuesta = false;
            $ListaJuego = Juego::JuegoListarLapsoJson();
            foreach ($ListaJuego as $juego) {
                $evento_creado = Evento::ObtenerUltimoEvento($juego->idJuego, $fecha_inicio, $fecha_fin);
                if ($evento_creado != null) {
                    $fechaIni = "";
                    $fechaFin = "";
                    if ($juego->lapsoProxEventoHoras > 0) {
                        $NumeroHoras = $juego->lapsoProxEventoHoras;
                        $fechaIni = $evento_creado->fechaFinEvento;
                        $fechaFin = Carbon::parse($evento_creado->fechaFinEvento)->addHours($NumeroHoras);
                    } else if ($juego->lapsoProxEventoMinutos > 0) {
                        $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                        $fechaIni = $evento_creado->fechaFinEvento;
                        $fechaFin = Carbon::parse($evento_creado->fechaFinEvento)->addMinutes($NumeroMinutos);
                    }
                    if ($fechaFin >= $fecha_fin) {
                        $respuesta = true;
                        break;
                    } else {
                        Evento::RegistrarEvento($juego, $fechaFin, $fechaIni);
                    }
                } else {
                    if ($juego->lapsoProxEventoHoras > 0) {
                        $NumeroHoras = $juego->lapsoProxEventoHoras;
                        $fecha = Carbon::parse($fecha_inicio)->addHours($NumeroHoras);
                        Evento::RegistrarEvento($juego, $fecha, $fecha_inicio);
                    } else if ($juego->lapsoProxEventoMinutos > 0) {
                        $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                        $fecha = Carbon::parse($fecha_inicio)->addMinutes($NumeroMinutos);
                        Evento::RegistrarEvento($juego, $fecha, $fecha_inicio);
                    }
                }
            }
            if ($respuesta) {
                break;
            }
        }
    }

    public static function EventoEjecucionUnico()
    {
        $evento = DB::table('evento')
            ->where('estadoEvento', 1)
            ->first();
        return $evento;
    }

    public static function GenerarResultadoEvento_CambiarEstadoEvento()
    {
        $Configuracion = DB::table('configuracion_generar_evento')
            ->first();
        if ($Configuracion != null) {
            $fechaIni = today()->toDateString() . ' ' . $Configuracion->HoraInicioIntervalo;
            $fechaFin = today()->toDateString() . ' ' . $Configuracion->HoraFinIntervalo;
        } else {
            $fechaIni = today()->startOfDay()->toDateTimeString();
            $fechaFin = today()->endOfDay()->toDateTimeString();
        }
        
        $ListaEventosDia = DB::table('evento as e')
            ->whereBetween('e.fechaEvento', array($fechaIni, $fechaFin))
            ->get();

        foreach ($ListaEventosDia as $li) {
            if ($li->fechaEvento < now() && $li->fechaFinEvento > now()) {
                $val = Evento::findorfail($li->idEvento);
                if ($val->estadoEvento == 0) {
                    $val->estadoEvento = 1;
                    $val->save();
                    $numero_random = rand(0, 36);
                    TipoApuesta::TipoApuestaColor($numero_random, $val->idEvento);
                }
            } else if ($li->fechaEvento < now() && $li->fechaFinEvento < now() && $li->estadoEvento == 1) {
                $evento = Evento::findorfail($li->idEvento);
                $evento->estadoEvento = 2;
                $evento->save();
            }
        }

    }

    public
    static function CerrarEventoJuego($IdJuego)
    {
        $UltimoEvento = Evento::where('idJuego', $IdJuego)->first();
        $resultado = Evento::findorfail($UltimoEvento->idEvento);
        $resultado->estadoEvento = 2;
        $resultado->save();
    }
}
