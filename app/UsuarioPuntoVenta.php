<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UsuarioPuntoVenta extends Model
{
    protected $table = 'usuario_punto_venta';

    protected $primaryKey = 'idUsuarioPuntoVenta';

    public $timestamps = false;

    protected $fillable = [
        'idUsuarioPuntoVenta',
        'idUsuario',
        'idPuntoVenta',
        'estado'
    ];

    public static function UsuarioPuntoVentaListarJson()
    {
        $listar = DB::select(DB::raw("SELECT u.idUsuario,u.usuario,
        (select COUNT(upv1.idUsuarioPuntoVenta) FROM usuario_punto_venta upv1 WHERE upv1.idUsuario = upv.idUsuario AND upv1.estado = 1) total
        FROM users u
        LEFT JOIN usuario_punto_venta upv ON upv.idUsuario = u.idUsuario
        GROUP BY u.usuario,upv.idUsuario,u.idUsuario"));
        return $listar;
    }

    public static function UsuarioPuntoVentaObtener(Request $request)
    {
        $idUsuario = $request->input('idUsuario');
        $resultado = DB::table('usuario_punto_venta')
            ->select('idPuntoVenta')
            ->where('idUsuario', $idUsuario)
            ->where('estado',1)
            ->get();
        $data = [];
        foreach ($resultado as $r) {
            $data[] = $r->idPuntoVenta;
        }
        return $data;
    }

    public static function UsuarioPuntoVentaInsertarJson(Request $request)
    {
        $usupuntoventa = new UsuarioPuntoVenta();
        $usupuntoventa->idUsuarioPuntoVenta = $request->input('idUsuarioPuntoVenta');
        $usupuntoventa->idUsuario = $request->input('idUsuario');
        $usupuntoventa->idPuntoVenta = $request->input('idPuntoVenta');
        $usupuntoventa->estado = $request->input('estado');
        $usupuntoventa->save();
    }

    public static function UsuarioPuntoVentaEditarJson(Request $request)
    {
        $usupuntoventa = UsuarioPuntoVenta::findorfail($request->input('idUsuarioPuntoVenta'));
        $usupuntoventa->idUsuarioPuntoVenta = $request->input('idUsuarioPuntoVenta');
        $usupuntoventa->idUsuario = $request->input('idUsuario');
        $usupuntoventa->idPuntoVenta = $request->input('idPuntoVenta');
        $usupuntoventa->estado = $request->input('estado');
        $usupuntoventa->save();
    }

    public static function TotalPuntoVentaUsuario($IdUsuario)
    {
        $total = DB::table('usuario_punto_venta')
            ->where('idUsuario', $IdUsuario)
            ->where('estado', 1)
            ->count();
        return $total;
    }

    public static function ValidarPuntoVentaUsuario($IdUsuario, $IdPuntoVenta)
    {
        $data = DB::table('usuario_punto_venta')
            ->where('idUsuario', $IdUsuario)
            ->where('idPuntoVenta', $IdPuntoVenta)
            ->first();
        return $data;
    }

    public static function AgregarPuntoVentaUsuario(Request $request)
    {
        $IdUsuario = $request->input('IdUsuario');
        $IdPuntoVenta = $request->input('IdPuntoVenta');
        $respuesta = UsuarioPuntoVenta::ValidarPuntoVentaUsuario($IdUsuario, $IdPuntoVenta);
        if ($respuesta != null){
            $usupuntoventa = UsuarioPuntoVenta::findorfail($respuesta->idUsuarioPuntoVenta);
            $usupuntoventa->estado = 1;
            $usupuntoventa->save();
        }else{
            $usupuntoventa = new UsuarioPuntoVenta();
            $usupuntoventa->idUsuario = $request->input('IdUsuario');
            $usupuntoventa->idPuntoVenta = $request->input('IdPuntoVenta');
            $usupuntoventa->estado = 1;
            $usupuntoventa->save();
        }
    }

    public static function QuitarPuntoVentaUsuario(Request $request)
    {
        $IdUsuario = $request->input('IdUsuario');
        $IdPuntoVenta = $request->input('IdPuntoVenta');
        $respuesta = UsuarioPuntoVenta::ValidarPuntoVentaUsuario($IdUsuario, $IdPuntoVenta);
        $usupuntoventa = UsuarioPuntoVenta::findorfail($respuesta->idUsuarioPuntoVenta);
        $usupuntoventa->estado = 0;
        $usupuntoventa->save();

//        DB::table('usuario_punto_venta')
//            ->where('idUsuario', $request->input('IdUsuario'))
//            ->where('idPuntoVenta', $request->input('IdPuntoVenta'))
//            ->delete();
    }


}
