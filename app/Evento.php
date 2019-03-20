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
        'apuestaMinima',
        'apuestaMaxima',
        'fechaEventoReprogramacion',
        'idMoneda',
        'estadoEvento'
    ];

    public $timestamps = false;

    public static function EventoListar()
    {
        $listar = DB::select(DB::raw('
select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1'));
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
        $listar = DB::select(DB::raw("select  COUNT(*)  as cantidadganadores FROM ticket WHERE IDEVENTO =" . $idEvento));
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
    public static function JackPotEvento($idEvento)
    {
        $listar = DB::select(DB::raw("select  POL.montoActual FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=1
			"));
        return $listar;
    }

    public static function JackPotSumaEvento($idEvento)
    {
        $listar = DB::select(DB::raw("select  sum(POL.montoActual) as sumajackpots FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=1
			"));
        return $listar;
    }


    public static function HistorialEvento($ideventoactual)
    {

        $listar = DB::select(DB::raw("select  res.`valorGanador`,tipo_apuesta.rgb as color FROM  `resultado_evento` res
inner join evento evt on res.`idEvento`=evt.`idEvento`
left join tipo_apuesta on tipo_apuesta.idTipoApuesta=res.idTipoApuesta
WHERE evt.IDJUEGO=1 and res.idtipopago=1 and evt.idEvento!=".$ideventoactual." 
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

    public static function RegistrarEvento($juego, $fechaEvento)
    {
        $evento = new Evento();
        $evento->idJuego = $juego->idJuego;
        $evento->nombre = $juego->nombre;
        $evento->fechaEvento = $fechaEvento;
        $evento->apuestaMinima = $juego->apuestaMinima;
        $evento->apuestaMaxima = $juego->apuestaMaxima;
        $evento->idMoneda = $juego->idMoneda;
        $evento->estadoEvento = 1;
        $evento->save();
    }

    public static function GenerarEventoJob()
    {
        $ListaJuego = Juego::JuegoListarLapsoJson();
        foreach ($ListaJuego as $juego) {
            $JuegoEvento = Juego::JuegoEventoEjecucion($juego->idJuego);
            if ($JuegoEvento != null) {
                if (now() >= $JuegoEvento->fechaEvento) {
                    $respuesta = Juego::ActualizarEventoEjecucion($JuegoEvento->idEvento);
                    if ($respuesta) {
                        $numero_random = rand(0, 24);
                        TipoApuesta::TipoApuestaColor($numero_random, $JuegoEvento->idEvento);

                        if ($juego->lapsoProxEventoHoras > 0) {
                            $NumeroHoras = $juego->lapsoProxEventoHoras;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addHours($NumeroHoras);
                            Evento::RegistrarEvento($juego, $fecha);
                        } else if ($juego->lapsoProxEventoDia > 0) {
                            $NumeroDias = $juego->lapsoProxEventoDia;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addDays($NumeroDias);
                            Evento::RegistrarEvento($juego, $fecha);
                        } else if ($juego->lapsoProxEventoMinutos > 0) {
                            $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addMinutes($NumeroMinutos);
                            Evento::RegistrarEvento($juego, $fecha);
                        }
                    }
                }
            } else {
                //crear evento desde 0
                if ($juego->lapsoProxEventoHoras > 0) {
                    $NumeroHoras = $juego->lapsoProxEventoHoras;
                    $fecha = now()->addHours($NumeroHoras);
                    Evento::RegistrarEvento($juego, $fecha);
                } else if ($juego->lapsoProxEventoDia > 0) {
                    $NumeroDias = $juego->lapsoProxEventoDia;
                    $fecha = now()->addDays($NumeroDias);
                    Evento::RegistrarEvento($juego, $fecha);
                } else if ($juego->lapsoProxEventoMinutos > 0) {
                    $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                    $fecha = now()->addMinutes($NumeroMinutos);
                    Evento::RegistrarEvento($juego, $fecha);
                }
            }
        }
    }


}
