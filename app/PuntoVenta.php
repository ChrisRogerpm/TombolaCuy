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
        pv.cc_id,
        (SELECT u.nombre FROM ubigeo u
        WHERE u.idUbigeo = pv.idUbigeo) Ubigeo,
        pv.ZonaComercial
        FROM punto_venta pv
        LEFT JOIN empresa e ON e.idEmpresa = pv.idEmpresa"));
        return $listar;
    }

    public static function PuntoVentaUsuarioAlerta(Request $request)
    {
        $idTipoAlerta = $request->input('idTipoAlerta');
        $idUsuario = Auth::user()->idUsuario;
        $lista = DB::select(DB::raw("SELECT * 
        FROM usuario_punto_venta upv
        JOIN punto_venta p ON p.idPuntoVenta = upv.idPuntoVenta
        WHERE 
        upv.idUsuario = $idUsuario 
        AND upv.estado = 1
        AND upv.idPuntoVenta not IN (SELECT pta.idPuntoVenta 
        FROM punto_venta_tipo_alerta pta WHERE pta.estado = 1  AND pta.idTipoAlerta = $idTipoAlerta)"));
        return $lista;
    }

    public static function PuntoVentaListarUsuarioJson()
    {
        $IdUsuario = Auth::user()->idUsuario;
        $lista_punto_venta_usuario = UsuarioPuntoVenta::where('idUsuario', $IdUsuario)
            ->where('estado', 1)
            ->get();
        $data = [];
        foreach ($lista_punto_venta_usuario as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = is_array($data) ? implode(",", $data) : $data;
        if ($data == "") {
            $lista = [];
            return $lista;
        } else {
            $lista = DB::select(DB::raw("SELECT 
            pv.*,
            e.razonSocial,
            (SELECT u.nombre FROM ubigeo u
            WHERE u.idUbigeo = pv.idUbigeo) Ubigeo
            FROM punto_venta pv
            LEFT JOIN empresa e ON e.idEmpresa = pv.idEmpresa
            WHERE pv.idPuntoVenta IN ($data)"));
            return $lista;
        }
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
        $punto_venta->cc_id = $request->input('cc_id');
        $punto_venta->ZonaComercial = $zonaComercial;
        $punto_venta->save();
        return $punto_venta;
    }

    public static function PuntoVentaZonaListarUsuarioJson(Request $request)
    {
        $IdUsuario = Auth::user()->idUsuario;
        $IdZonaComercial = $request->input('IdZonaComercial');
        $condicional = $IdZonaComercial == 0 ? '' : 'AND pv.ZonaComercial = ' . $IdZonaComercial;
        $lista_punto_venta_usuario = UsuarioPuntoVenta::where('idUsuario', $IdUsuario)->where('estado', 1)->get();
        $data = [];
        foreach ($lista_punto_venta_usuario as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = is_array($data) ? implode(",", $data) : $data;
        $listar = DB::select(DB::raw("SELECT * 
        FROM punto_venta pv
        WHERE pv.idPuntoVenta IN ($data)  
        $condicional"));
        return $listar;
    }

    public static function PuntoVentaInfo($idPuntoVenta)
    {
        $data = PuntoVenta::findorfail($idPuntoVenta);
        return $data;
    }

}
