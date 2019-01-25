<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TipoApuesta extends Model
{
    protected $table = 'tipo_apuesta';

    protected $primaryKey = 'idTipoApuesta';

    public $timestamps = false;

    public $fillable = ['idTipoPago'.'valorapuesta','nombre', 'estado'];


    public static function TipoApuestaListarJson()
    {
        $listar = TipoApuesta::all();
        return $listar;
    }

    public static function TipoApuestaInsertarJson(Request $request)
    {
        $TipoApuesta = new TipoApuesta();
        

        $TipoApuesta->idTipoPago = $request->input('idTipoPago');
        $TipoApuesta->valorapuesta = $request->input('valorapuesta');
        $TipoApuesta->nombre = $request->input('nombre');

        $TipoApuesta->estado = 1;
        $TipoApuesta->save();
        return $TipoApuesta;
    }

    public static function TipoApuestaEditarJson(Request $request)
    {
        $idTipoApuesta = $request->input('idTipoApuesta');
        $TipoApuesta = TipoApuesta::findorfail($idTipoApuesta);
        $TipoApuesta->idTipoPago = $request->input('idTipoPago');
        $TipoApuesta->valorapuesta = $request->input('valorapuesta');
        $TipoApuesta->nombre = $request->input('nombre');
        $TipoApuesta->estado = $request->input('estado');
        $TipoApuesta->save();
        return $TipoApuesta;
    }
}
