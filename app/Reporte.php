<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reporte extends Model
{
    //
//    protected $table = 'tipo_apuesta';
//
//    protected $primaryKey = 'idTipoApuesta';
//
//    public $timestamps = false;
//
//    public $fillable = ['idTipoPago' . 'valorapuesta', 'nombre', 'estado'];

    public static function ReporteApuestaJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = $request->input('fechaInicial');
        $fechaFin = $request->input('fechaFinal');

        $lista = DB::table('apuesta as a')
            ->select(DB::raw("sum(a.montoApostado) Apuestas ,sum(a.montoAPagar) Pagos,e.nombre,sum(t.idTicket) Jugadores"))
//            ->select()
            ->select(DB::raw("sum(a.montoApostado) as Apuestas"), DB::raw("sum(a.montoAPagar) as Pagos"), DB::raw("sum(t.idTicket) Jugadores"))
            ->join('ticket as t', 't.idTicket', 'a.idTicket')
            ->join('evento as e', 'e.idEvento', 't.idEvento')
            ->join('apertura_caja as ac', 'ac.idAperturaCaja', 't.idAperturaCaja')
            ->join('caja as c', 'c.idCaja', 'ac.idCaja')
            ->join('punto_venta as pv', 'pv.idPuntoVenta', 'c.idPuntoVenta')
//            ->whereIn('pv.idPuntoVenta',$tiendas)
            ->whereIn('pv.idPuntoVenta', $tiendas)
            ->whereBetween('e.fechaEvento', [$fechaIni, $fechaFin])
            ->get();
        return $lista;

    }

    public static function ReporteHistorialGanadoresListarJson()
    {
        
      
        $listar = DB::select(DB::raw("
        SELECT 
        pv.nombre tienda,
        /*eve.idEvento IdEvento,*/
        eve.nombre evento, 
        eve.fechaEvento fecha,
        /*sum(apu.montoAPagar),*/
        tic.idTicket total_jugadores,
        tic.ganador total_ganadores,
        tic.montoTotal monto_total_apostado, 
        apu.montoAPagar monto_total_pagado,

        tic.nroTicketParticipante NR_ticket_ganador,
        apu.montoAPagar,
        tpago.nombre tipo_de_apuesta,
        tapu.nombre valor_de_apuesta
        from ganador_evento gev
        INNER JOIN apuesta apu on apu.idApuesta=gev.idApuesta
        INNER JOIN ticket tic on tic.idTicket=apu.idTicket
        INNER JOIN apertura_caja apc on apc.idAperturaCaja=tic.idAperturaCaja
        INNER JOIN caja caj on caj.idCaja=apc.idCaja
        INNER JOIN evento eve ON eve.idEvento = tic.idEvento
        INNER JOIN punto_venta pv ON pv.idPuntoVenta= caj.idPuntoVenta
        INNER JOIN tipo_apuesta tapu ON tapu.idTipoApuesta = apu.idTipoApuesta
        INNER JOIN tipo_pago tpago ON tpago.idTipoPago= tapu.idTipoPago
        "));
                return $listar;
    }
}
