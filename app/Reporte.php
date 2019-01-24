<?php

namespace App;

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
    }

    public static function ReporteHistorialGanadoresListarJson()
    {
        $listar = Reporte::all();
        return $listar;
    }
}
