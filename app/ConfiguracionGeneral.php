<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConfiguracionGeneral extends Model
{
    protected $table = 'configuracion_general';

    protected $primaryKey = 'idConfiguracion';

    public $timestamps = false;

    protected $fillable = [
        'HoraInicioIntervalo',
        'HoraFinIntervalo',
        'CobrarTicket',
        'CuentaCorreo',
        'PasswordCorreo',
        'SMTP',
        'SSL',
    ];

    public static function ObtenerConfiguracionEvento()
    {
        $resultado = DB::table('configuracion_general')->first();
        return $resultado;
    }

    public static function ConfiguracionEventoInsertar(Request $request)
    {
        $configuracion = ConfiguracionGeneral::ObtenerConfiguracionEvento();
        if ($configuracion != null) {
            $conf = ConfiguracionGeneral::findorfail($configuracion->idConfiguracion);
            $conf->HoraInicioIntervalo = $request->input('HoraInicioIntervalo');
            $conf->HoraFinIntervalo = $request->input('HoraFinIntervalo');
            $conf->save();
        } else {
            $conf = new ConfiguracionGeneral();
            $conf->HoraInicioIntervalo = $request->input('HoraInicioIntervalo');
            $conf->HoraFinIntervalo = $request->input('HoraFinIntervalo');
            $conf->save();
        }
    }

    public static function ConfiguracionCobrarTicket(Request $request)
    {
        $configuracion = ConfiguracionGeneral::ObtenerConfiguracionEvento();
        if ($configuracion != null) {
            $conf = ConfiguracionGeneral::findorfail($configuracion->idConfiguracion);
            $conf->CobrarTicket = $request->input('CobrarTicket');
            $conf->save();
        } else {
            $conf = new ConfiguracionGeneral();
            $conf->CobrarTicket = $request->input('CobrarTicket');
            $conf->save();
        }
    }

    public static function ConfiguracionCuentaCorreo(Request $request)
    {
        $configuracion = ConfiguracionGeneral::ObtenerConfiguracionEvento();
        if ($configuracion != null) {
            $conf = ConfiguracionGeneral::findorfail($configuracion->idConfiguracion);
            $conf->CuentaCorreo = $request->input('CuentaCorreo');
            $conf->PasswordCorreo = $request->input('PasswordCorreo');
            $conf->SMTP = $request->input('SMTP');
            $conf->SSL = $request->input('SSL');
            $conf->save();
        } else {
            $conf = new ConfiguracionGeneral();
            $conf->CuentaCorreo = $request->input('CuentaCorreo');
            $conf->PasswordCorreo = $request->input('PasswordCorreo');
            $conf->SMTP = $request->input('SMTP');
            $conf->SSL = $request->input('SSL');
            $conf->save();
        }
    }
}
