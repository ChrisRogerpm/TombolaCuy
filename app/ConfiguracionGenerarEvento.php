<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConfiguracionGenerarEvento extends Model
{
    protected $table = 'configuracion_generar_evento';

    protected $primaryKey = 'idConfiguracion';

    public $timestamps = false;

    protected $fillable = [
        'HoraInicioIntervalo',
        'HoraFinIntervalo',
        'HoraEjecucion',
    ];

    public static function ObtenerConfiguracionGenerarEvento()
    {
        $resultado = DB::table('configuracion_generar_evento')
            ->first();
        return $resultado;
    }

    public static function ConfiguracionGenerarEventoInsertar(Request $request)
    {
        $configuracion = ConfiguracionGenerarEvento::ObtenerConfiguracionGenerarEvento();
        if ($configuracion != null) {
            $conf = ConfiguracionGenerarEvento::findorfail($configuracion->idConfiguracion);
            $conf->HoraInicioIntervalo = $request->input('HoraInicioIntervalo');
            $conf->HoraFinIntervalo = $request->input('HoraFinIntervalo');
            $conf->HoraEjecucion = $request->input('HoraEjecucion');
            $conf->save();
        } else {
            $conf = new ConfiguracionGenerarEvento();
            $conf->HoraInicioIntervalo = $request->input('HoraInicioIntervalo');
            $conf->HoraFinIntervalo = $request->input('HoraFinIntervalo');
            $conf->HoraEjecucion = $request->input('HoraEjecucion');
            $conf->save();
        }
    }
}
