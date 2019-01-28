<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Evento extends Model
{
    protected $table = 'evento';

    protected $primaryKey = 'idEvento';

    //protected $fillable = ['nombre', 'superjackpot', 'estado'];

    public $timestamps = false;


    public static function EventoListar()
    {
       
        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
where ev.estadoEvento=1'));
        return $listar;
    }
       public static function EventoId($idEvento)
    {
       
        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
where ev.estadoEvento=1 and idEvento='.$idEvento));
        return $listar;
    }
    public static function CantidadGanadorEventoListar($idEvento)
    {
        $listar = DB::select(DB::raw("select  COUNT(*)  as cantidadganadores FROM ticket WHERE IDEVENTO =".$idEvento));
        return $listar;
    }
     public static function SimboloEvento($idEvento)
    {
        $listar = DB::select(DB::raw("select mon.simbolo as simbolo  FROM evento ev left join moneda mon on mon.idMoneda=ev.idMoneda WHERE IDEVENTO =".$idEvento));
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
        $listar = DB::select(DB::raw("
        SELECT 
            pv.nombre Punto_Venta,
            /*eve.idEvento IdEvento,*/
            eve.nombre Evento, 
            eve.fechaEvento,
            /*sum(apu.montoAPagar),*/
            tic.idTicket,
            tic.ganador,
            tic.montoTotal,
            apu.montoAPagar,

            tic.nroTicketParticipante,
            apu.montoAPagar,
            tpago.nombre,
            tapu.nombre
            from ganador_evento gev
            INNER JOIN apuesta apu on apu.idApuesta=gev.idApuesta
            INNER JOIN ticket tic on tic.idTicket=apu.idTicket
            INNER JOIN apertura_caja apc on apc.idAperturaCaja=tic.idAperturaCaja
            INNER JOIN caja caj on caj.idCaja=apc.idCaja
            INNER JOIN evento eve ON eve.idEvento = tic.idEvento
            INNER JOIN punto_venta pv ON pv.idPuntoVenta= caj.idPuntoVenta
            INNER JOIN tipo_apuesta tapu ON tapu.idTipoApuesta = apu.idTipoApuesta
            INNER JOIN tipo_pago tpago ON tpago.idTipoPago= tapu.idTipoPago"));
        return $listar;
    }






}
