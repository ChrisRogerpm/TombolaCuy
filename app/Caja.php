<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Caja extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'idCaja';
    public $timestamps = false;
    protected $fillable = ['idPuntoVenta', 'nombre', 'estado'];


    public static function CajaListarJson()
    {
        $lista_puntos_venta = PuntoVenta::PuntoVentaListarUsuarioJson();
        $puntoventa = [];
        foreach ($lista_puntos_venta as $lpv) {
            $puntoventa [] = $lpv->idPuntoVenta;
        }
        $listar = DB::table('caja as c')
            ->select('c.idCaja', 'pv.nombre as PuntoVenta', 'c.nombre', 'c.estado')
            ->join('punto_venta as pv', 'pv.idPuntoVenta', 'c.idPuntoVenta')
            ->whereIn('c.idPuntoVenta', $puntoventa)
            ->get();
        return $listar;
    }

    public static function CajaInsertarJson(Request $request)
    {
        $Caja = new Caja();
        $Caja->idPuntoVenta = $request->input('idPuntoVenta');
        $Caja->nombre = $request->input('nombre');
        $Caja->estado = 1;
        $Caja->save();
        return $Caja;
    }

    public static function CajaEditarJson(Request $request)
    {
        $idCaja = $request->input('idCaja');

        $Caja = Caja::findorfail($idCaja);
        $Caja->idPuntoVenta = $request->input('idPuntoVenta');
        $Caja->nombre = $request->input('nombre');
        $Caja->estado = $request->input('estado');
        $Caja->save();
        return $Caja;
    }

    public static function CajaPuntoVentaUsuario()
    {
        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        $resultado = "";
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        if (count($data) > 0) {
            $data = implode(",", $data);
            $resultado = DB::select(DB::raw("SELECT c.idCaja,CONCAT(c.nombre,' - ',p.nombre) NombreCaja
            FROM caja c
            JOIN punto_venta p ON p.idPuntoVenta = c.idPuntoVenta
            WHERE c.idPuntoVenta IN ($data)"));
        }
        return $resultado;

    }
}
