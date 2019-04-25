<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PuntoVenta extends Model
{
    protected $table = 'punto_venta';

    protected $primaryKey = 'idPuntoVenta';

    public $timestamps = false;

    public $fillable = ['idEmpresa', 'idUbigeo', 'nombre', 'cc_id', 'unit_ids', 'ZonaComercial'];

    public static function PuntoVentaListarJson()
    {
        $listar = DB::select(DB::raw("SELECT 
        pv.idPuntoVenta,
        pv.nombre,
        e.razonSocial,
        (SELECT u.nombre FROM ubigeo u
        WHERE u.cod_depa = pv.idUbigeo AND u.cod_prov ='00' AND u.cod_dist='00') Ubigeo,
        pv.ZonaComercial
        FROM punto_venta pv
        LEFT JOIN empresa e ON e.idEmpresa = pv.idEmpresa"));
        return $listar;
    }

    public static function PuntoVentaListarUsuarioJson()
    {
        $IdUsuario = Auth::user()->idUsuario;
        $lista_punto_venta_usuario = UsuarioPuntoVenta::where('idUsuario', $IdUsuario)->get();
        $data = [];
        foreach ($lista_punto_venta_usuario as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $listar = DB::table('punto_venta as pv')
            ->whereIn('pv.idPuntoVenta', $data)
            ->get();
        return $listar;
    }

    public static function PuntoVentaInsertarJson(Request $request)
    {
        $zonaComercial = Ubigeo::ObtenerZonaComercial($request->input('idUbigeo'));
        $punto_venta = new PuntoVenta();
        $punto_venta->idEmpresa = $request->input('idEmpresa');
        $punto_venta->idUbigeo = $request->input('idUbigeo');
        $punto_venta->nombre = $request->input('nombre');
        $punto_venta->ZonaComercial = $zonaComercial;
        $punto_venta->save();
        return $punto_venta;
    }

    public static function PuntoVentaEditarJson(Request $request)
    {
        $idPuntoVenta = $request->input('idPuntoVenta');
        $zonaComercial = Ubigeo::ObtenerZonaComercial($request->input('idUbigeo'));

        $punto_venta = PuntoVenta::findorfail($idPuntoVenta);
        $punto_venta->idEmpresa = $request->input('idEmpresa');
        $punto_venta->idUbigeo = $request->input('idUbigeo');
        $punto_venta->nombre = $request->input('nombre');
        $punto_venta->ZonaComercial = $zonaComercial;
        $punto_venta->save();
        return $punto_venta;
    }

    public static function PuntoVentaZonaListarUsuarioJson(Request $request)
    {
        $IdUsuario = Auth::user()->idUsuario;
        $IdZonaComercial = $request->input('IdZonaComercial');
        $condicional = $IdZonaComercial == 0 ? '' : 'AND pv.ZonaComercial = ' . $IdZonaComercial;
        $lista_punto_venta_usuario = UsuarioPuntoVenta::where('idUsuario', $IdUsuario)->get();
        $data = [];
        foreach ($lista_punto_venta_usuario as $l) {
            $data [] = $l->idPuntoVenta;
        }

        $data = is_array($data) ? implode(",", $data) : $data;

        $listar = DB::select(DB::raw("SELECT * 
        FROM punto_venta pv
        WHERE pv.idPuntoVenta IN ($data)  $condicional"));
        return $listar;
    }

}
