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
        $obj = new stdClass();
        $obj->idConfiguracion = $resultado->idConfiguracion;
        $obj->HoraInicioIntervalo = $resultado->HoraInicioIntervalo;
        $obj->HoraFinIntervalo = $resultado->HoraFinIntervalo;
        $obj->CobrarTicket = $resultado->CobrarTicket;
        $obj->CuentaCorreo = Crypt::decryptString($resultado->CuentaCorreo);
        $obj->PasswordCorreo = Crypt::decryptString($resultado->PasswordCorreo);
        $obj->SMTP = Crypt::decryptString($resultado->SMTP);
        $obj->SSL = Crypt::decryptString($resultado->SSL);
        return $obj;
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
            $conf->CuentaCorreo = Crypt::encryptString($request->input('CuentaCorreo'));
            $conf->PasswordCorreo = Crypt::encryptString($request->input('PasswordCorreo'));
            $conf->SMTP = Crypt::encryptString($request->input('SMTP'));
            $conf->SSL = Crypt::encryptString($request->input('SSL'));
            $conf->save();
        } else {
            $conf = new ConfiguracionGeneral();
            $conf->CuentaCorreo = Crypt::encryptString($request->input('CuentaCorreo'));
            $conf->PasswordCorreo = Crypt::encryptString($request->input('PasswordCorreo'));
            $conf->SMTP = Crypt::encryptString($request->input('SMTP'));
            $conf->SSL = Crypt::encryptString($request->input('SSL'));
            $conf->save();
        }
    }
}
