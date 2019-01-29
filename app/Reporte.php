<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Reporte extends Model
{
    //
     protected $table = 'tipo_apuesta';

    protected $primaryKey = 'idTipoApuesta';

    public $timestamps = false;

    public $fillable = ['idTipoPago'.'valorapuesta','nombre', 'estado'];
    
    public static function ReporteApuestaJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = $request->input('fechaInicial');
        $fechaFin = $request->input('fechaFinal');
    }

    public static function ReporteHistorialGanadoresListarJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = $request->input('fechaInicial');	        
        $fechaFin = $request->input('fechaFinal');	      
      
        $listar = DB::select(DB::raw("
        SELECT 
        caj.idPuntoVenta,
        pv.nombre tienda,
        eve.idEvento IdEvento,
        eve.nombre evento, 
        eve.fechaEvento fecha,
        tic.idTicket total_jugadores,
        tic.ganador total_ganadores,
        tic.montoTotal monto_total_apostado,
        apu.montoAPagar monto_total_pagado,
        tic.nroTicketParticipante NR_ticket_ganador,
        tpago.nombre tipo_de_apuesta,
        tapu.nombre valor_de_apuesta,
        tapu.rgb valor_apuesta_color_rgb
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

        
        // ejemplo where in
        // $users = DB::table('users')
        //             ->whereIn('id', [1, 2, 3])
        //             ->get();
        
                return $listar;
    }
}
