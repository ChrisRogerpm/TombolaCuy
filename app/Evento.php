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

        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1'));
        return $listar;
    }

    public static function EventoId($idEvento)
    {

        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,ju.logo as logo,
        	ju.segBloqueoAntesEvento as segBloqueoAntesEvento,
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


    public static function HistorialEvento()
    {

        $listar = DB::select(DB::raw("select  res.`valorGanador`,tipo_apuesta.rgb as color FROM  `resultado_evento` res
inner join evento evt on res.`idEvento`=evt.`idEvento`
left join tipo_apuesta on tipo_apuesta.idTipoApuesta=res.idTipoApuesta
WHERE evt.IDJUEGO=1 and res.idtipopago=1
order by evt.`fechaEvento` DESC
LIMIT 20
			"));
        return $listar;
    }

    public static function TipoApuestaListar()
    {
        $listar = DB::select(DB::raw("
      select * from tipo_apuesta tip_apu LEFT JOIN tipo_pago tip_pag on tip_pag.idTipopago= tip_apu.idTipoPago"));
        return $listar;
    }

    public static function DineroDefaultListar()
    {
        $listar = DB::select(DB::raw("select * from dinero_default"));
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




}
