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
        $fechaIni = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $lista = DB::select(DB::raw("SELECT
        pv.nombre as Tienda,
        e.nombre as Evento,
        (SELECT
        sum(ap1.montoApostado) as apostado
        from apuesta ap1
        JOIN ticket t1 ON t1.idTicket = ap1.idTicket
        JOIN evento e1 ON e1.idEvento = t1.idEvento
        JOIN apertura_caja ac1 ON ac1.idAperturaCaja = t1.idAperturaCaja
        JOIN caja c1 ON c1.idCaja = ac1.idCaja
        JOIN punto_venta pv1 ON pv1.idPuntoVenta = c1.idPuntoVenta
        WHERE pv1.idPuntoVenta = pv.idPuntoVenta) Apuestas,
        (SELECT
        sum(ap2.montoAPagar) as Pagar
        from apuesta ap2
        JOIN ticket t2 ON t2.idTicket = ap2.idTicket
        JOIN evento e2 ON e2.idEvento = t2.idEvento
        JOIN apertura_caja ac2 ON ac2.idAperturaCaja = t2.idAperturaCaja
        JOIN caja c2 ON c2.idCaja = ac2.idCaja
        JOIN punto_venta pv2 ON pv2.idPuntoVenta = c2.idPuntoVenta
        WHERE pv2.idPuntoVenta = pv.idPuntoVenta) Pagos,
        (SELECT
        SUM(t3.idTicket) Jugadores
        from apuesta ap3
        JOIN ticket t3 ON t3.idTicket = ap3.idTicket
        JOIN evento e3 ON e3.idEvento = t3.idEvento
        JOIN apertura_caja ac3 ON ac3.idAperturaCaja = t3.idAperturaCaja
        JOIN caja c3 ON c3.idCaja = ac3.idCaja
        JOIN punto_venta pv3 ON pv3.idPuntoVenta = c3.idPuntoVenta
        WHERE pv3.idPuntoVenta = pv.idPuntoVenta) Jugadores
        FROM apuesta a
        JOIN ticket t ON t.idTicket = a.idTicket
        JOIN evento e ON e.idEvento = t.idEvento
        JOIN apertura_caja ac ON ac.idAperturaCaja = t.idAperturaCaja
        JOIN caja c ON c.idCaja = ac.idCaja
        JOIN punto_venta pv ON pv.idPuntoVenta = c.idPuntoVenta
        where pv.idPuntoVenta in ($tiendas) and
        e.fechaEvento between '$fechaIni' and '$fechaFin'
        GROUP BY pv.idPuntoVenta,e.nombre,pv.nombre"));
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
