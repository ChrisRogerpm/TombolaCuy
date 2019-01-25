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
        $listar = Reporte::all();
        return $listar;
    }
}
