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

    public static function ReporteHistorialGanadoresListarJson()
    {
        $listar = Reporte::all();
        return $listar;
    }
}
