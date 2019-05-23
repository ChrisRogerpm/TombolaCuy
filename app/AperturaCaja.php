<?php

namespace App;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AperturaCaja extends Model
{
    protected $table = 'apertura_caja';
    protected $primaryKey = 'idAperturaCaja';
    public $timestamps = false;
    protected $fillable = ['idCaja', 'idTurno', 'usuario', 'fechaOperacion', 'fechaRegistro', 'estado', 'fechaCierre'];

    public static function AperturaCajaListarJson()
    {
//        $listar = DB::table('apertura_caja as ac')
//            ->select('ac.idAperturaCaja', 'c.nombre as Caja', 't.nombre as Turno', 'ac.usuario', 'ac.fechaOperacion', 'ac.fechaRegistro','ac.estado')
//            ->join('caja as c', 'c.idCaja', 'ac.idCaja')
//            ->join('turno as t', 't.idTurno', 'ac.idTurno')
//            ->get();
        $idUsuario_Activo = Auth::user()->idUsuario;
        $listar = DB::select(DB::raw("SELECT 
        ac.idAperturaCaja, 
        c.nombre AS Caja, 
        t.nombre AS Turno, 
        u.usuario,
        ac.fechaOperacion, 
        ac.fechaRegistro,
        ac.fechaCierre,
        ac.estado
        FROM apertura_caja ac
        JOIN caja c ON c.idCaja = ac.idCaja
        JOIN turno t ON t.idTurno = ac.idTurno
        JOIN users u ON u.idUsuario = ac.usuario
        WHERE ac.usuario = $idUsuario_Activo
        ORDER BY ac.idAperturaCaja desc"));
        return $listar;
    }


    public static function AperturaCajaDatos($idaperutaracaja)
    {

        $listar = DB::select(DB::raw("select ape.* , usu.usuario as usuarionombre
            from apertura_caja  ape
            left join users usu on usu.idUsuario=ape.usuario
            where ape.idAperturaCaja =" . $idaperutaracaja . " "));
        return $listar;

    }


    public static function AperturaCajaInsertarJson(Request $request)
    {
        $AperturaCaja = new AperturaCaja();
        $AperturaCaja->idCaja = $request->input('idCaja');
        $AperturaCaja->idTurno = $request->input('idTurno');
        $AperturaCaja->usuario = $request->input('idUsuario');
        $AperturaCaja->fechaOperacion = Carbon::parse($request->input('fechaOperacion'));
        $AperturaCaja->fechaRegistro = Carbon::now();
        $AperturaCaja->estado = 1;
        $AperturaCaja->save();
        return $AperturaCaja;
    }

    public static function AperturaCajaEditarJson(Request $request)
    {
        $idAperturaCaja = $request->input('idAperturaCaja');

        $AperturaCaja = AperturaCaja::findorfail($idAperturaCaja);
        $AperturaCaja->idCaja = $request->input('idCaja');
        $AperturaCaja->idTurno = $request->input('idTurno');
        $AperturaCaja->usuario = $request->input('usuario');
        $AperturaCaja->fechaOperacion = $request->input('fechaOperacion');
        $AperturaCaja->save();
        return $AperturaCaja;
    }

    public static function AperturaCajaListarActiva($usuario)
    {

        $listar = DB::select(DB::raw("select ape.idAperturaCaja,puntodeventa.idPuntoVenta,puntodeventa.idUbigeo,puntodeventa.nombre as tienda,caj.nombre as caja, 
            ape.fechaOperacion as fechaOperacion, tur.nombre as turno ,
            puntodeventa.cc_id 
            from apertura_caja  ape
            left join turno tur on tur.idTurno=ape.idTurno
            left join caja caj on caj.idCaja=ape.idCaja
            left join punto_venta as puntodeventa on puntodeventa.idPuntoVenta=caj.idPuntoVenta
            where ape.usuario =" . $usuario . " and ape.estado=1"));
        return $listar;


    }

    public static function AperturaCajaCerrarJson(Request $request)
    {
        $idAperturaCaja = $request->input('idAperturaCaja');
        $apertura = AperturaCaja::findorfail($idAperturaCaja);
        $apertura->fechaCierre = now()->toDateTimeString();
        $apertura->estado = 2;
        $apertura->save();
    }


}
