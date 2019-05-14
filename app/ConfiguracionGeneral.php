<?php

namespace App;

use Crypt;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use stdClass;

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
//        $obj = new stdClass();
//        $obj->idConfiguracion = $resultado->idConfiguracion;
//        $obj->HoraInicioIntervalo = $resultado->HoraInicioIntervalo;
//        $obj->HoraFinIntervalo = $resultado->HoraFinIntervalo;
//        $obj->CobrarTicket = $resultado->CobrarTicket;
//        $obj->CuentaCorreo = $resultado->CuentaCorreo;
//        $obj->PasswordCorreo = $resultado->PasswordCorreo;
//        $obj->SMTP = $resultado->SMTP;
//        $obj->SSL = $resultado->SSL;
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
