<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ReporteApuestaExport implements FromQuery
{
    use Exportable;

    // $tiendas,$fechaIni,$fechaFin

    public function __construct(string $tiendas, string $fechaIni, string $fechaFin)
    {
        $this->tiendas = $tiendas;
        $this->fechaIni = $fechaIni;
        $this->fechaFin = $fechaFin;
    }

    public function query()
    {
        // return Reporte::ReporteApuestaJson($request);
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
        WHERE pv1.idPuntoVenta = pv.idPuntoVenta AND e1.idEvento = e.idEvento) Apuestas,
        (SELECT
        sum(ap2.montoAPagar) as Pagar
        from apuesta ap2
        JOIN ticket t2 ON t2.idTicket = ap2.idTicket
        JOIN evento e2 ON e2.idEvento = t2.idEvento
        JOIN apertura_caja ac2 ON ac2.idAperturaCaja = t2.idAperturaCaja
        JOIN caja c2 ON c2.idCaja = ac2.idCaja
        JOIN punto_venta pv2 ON pv2.idPuntoVenta = c2.idPuntoVenta
        WHERE pv2.idPuntoVenta = pv.idPuntoVenta AND e2.idEvento = e.idEvento) Pagos,
        (SELECT
        SUM(t3.idTicket) Jugadores
        from apuesta ap3
        JOIN ticket t3 ON t3.idTicket = ap3.idTicket
        JOIN evento e3 ON e3.idEvento = t3.idEvento
        JOIN apertura_caja ac3 ON ac3.idAperturaCaja = t3.idAperturaCaja
        JOIN caja c3 ON c3.idCaja = ac3.idCaja
        JOIN punto_venta pv3 ON pv3.idPuntoVenta = c3.idPuntoVenta
        WHERE pv3.idPuntoVenta = pv.idPuntoVenta AND e3.idEvento = e.idEvento) Jugadores
        FROM apuesta a
        JOIN ticket t ON t.idTicket = a.idTicket
        JOIN evento e ON e.idEvento = t.idEvento
        JOIN apertura_caja ac ON ac.idAperturaCaja = t.idAperturaCaja
        JOIN caja c ON c.idCaja = ac.idCaja
        JOIN punto_venta pv ON pv.idPuntoVenta = c.idPuntoVenta
        where pv.idPuntoVenta in ($this->tiendas) and
        e.fechaEvento between '$this->fechaIni' and '$this->fechaFin'
        GROUP BY pv.idPuntoVenta,e.idEvento,pv.nombre,e.nombre"));

        $result = array();
        foreach ($lista as $key => $value) {
            $result[] = ['Tienda' => $value->Tienda, 'Evento' => $value->Evento, 'Apuestas' => $value->Apuestas, 'Pagos' => $value->Pagos, 'Jugadores' => $value->Jugadores];
        }
        $res = \App\PuntoVenta::all();
        return $res;
    }
}
