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

    public $fillable = ['idEmpresa', 'idUbigeo', 'nombre', 'cc_id', 'unit_ids'];

    public static function PuntoVentaListarJson()
    {
        $listar = DB::table('punto_venta as pv')
            ->select('pv.*', 'e.razonSocial', 'u.Nombre as Ubigeo')
            ->leftJoin('empresa as e', 'e.idEmpresa', 'pv.idEmpresa')
            ->leftJoin('ubigeo as u', 'u.idUbigeo', 'pv.idUbigeo')
            ->get();
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
        $punto_venta = new PuntoVenta();
        $punto_venta->idEmpresa = $request->input('idEmpresa');
        $punto_venta->idUbigeo = $request->input('idUbigeo');
        $punto_venta->nombre = $request->input('nombre');
        $punto_venta->save();
        return $punto_venta;
    }

    public static function PuntoVentaEditarJson(Request $request)
    {
        $idPuntoVenta = $request->input('idPuntoVenta');

        $punto_venta = PuntoVenta::findorfail($idPuntoVenta);
        $punto_venta->idEmpresa = $request->input('idEmpresa');
        $punto_venta->idUbigeo = $request->input('idUbigeo');
        $punto_venta->nombre = $request->input('nombre');
        $punto_venta->save();
        return $punto_venta;
    }

}
