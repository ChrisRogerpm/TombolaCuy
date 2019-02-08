<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class ConfiguracionPozo extends Model
{
    protected $table = 'configuracion_pozo';
    protected $primaryKey = 'idConfiguracionPozo';
    public $timestamps = false;
    protected $fillable = [
        'idConfiguracionJackpot',
        'numeroPozo',
        'montoBase',
        'montoBaseOculto',
        'incrementoJackpot',
        'incrementoPozoOculto',
        'limiteInferior',
        'limiteSuperior',
        'limiteInferiorOculto',
        'limiteSuperiorOculto'];

    public static function ConfiguracionPozoListarJson(Request $request)
    {
        $idConfiguracionJackpot = $request->input('idConfiguracionJackpot');
        $listar = ConfiguracionPozo::where('idConfiguracionJackpot', $idConfiguracionJackpot)->get();
        return $listar;
    }

    public static function ConfiguracionPozoInsertarJson($Pozo, $IdConfiguracionJackpot)
    {
        $configuracionPozo = new ConfiguracionPozo();
        $configuracionPozo->idConfiguracionJackpot = $IdConfiguracionJackpot;
        $configuracionPozo->numeroPozo = $Pozo['numeroPozo'];
        $configuracionPozo->montoBase = 0;
        $configuracionPozo->montoBaseOculto = 0;
        $configuracionPozo->incrementoJackpot = $Pozo['incrementoJackpot'];
        $configuracionPozo->incrementoPozoOculto = $Pozo['incrementoPozoOculto'];
        $configuracionPozo->limiteInferior = $Pozo['limiteInferior'];
        $configuracionPozo->limiteSuperior = $Pozo['limiteSuperior'];
        $configuracionPozo->limiteInferiorOculto = $Pozo['limiteInferiorOculto'];
        $configuracionPozo->limiteSuperiorOculto = $Pozo['limiteSuperiorOculto'];
        $configuracionPozo->estado = 1;
        $configuracionPozo->save();
        return $configuracionPozo;
    }

    public static function ConfiguracionPozoEliminarJson(Request $request)
    {
        $idConfiguracionPozo = $request->input('idConfiguracionPozo');
        $ConfiguracionPozo = ConfiguracionPozo::findorfail($idConfiguracionPozo);
        $ConfiguracionPozo->delete();
    }

    public static function CambiarEstadoConfiguracionPozoJson(Request $request)
    {
        $idConfiguracionPozo = $request->input('idConfiguracionPozo');
        $estado = $request->input('estado');
        $ConfiguracionPozo = ConfiguracionPozo::findorfail($idConfiguracionPozo);
        $ConfiguracionPozo->estado = $estado;
        $ConfiguracionPozo->save();
    }

    public static function ConfiguracionPozoEditarJson($Pozo, $IdConfiguracionJackpot)
    {
        $configuracionPozo = ConfiguracionPozo::findorfail($Pozo['idConfiguracionPozo']);
        $configuracionPozo->idConfiguracionJackpot = $IdConfiguracionJackpot;
        $configuracionPozo->numeroPozo = $Pozo['numeroPozo'];
        $configuracionPozo->montoBase = 0;
        $configuracionPozo->montoBaseOculto = 0;
        $configuracionPozo->incrementoJackpot = $Pozo['incrementoJackpot'];
        $configuracionPozo->incrementoPozoOculto = $Pozo['incrementoPozoOculto'];
        $configuracionPozo->limiteInferior = $Pozo['limiteInferior'];
        $configuracionPozo->limiteSuperior = $Pozo['limiteSuperior'];
        $configuracionPozo->limiteInferiorOculto = $Pozo['limiteInferiorOculto'];
        $configuracionPozo->limiteSuperiorOculto = $Pozo['limiteSuperiorOculto'];
        $configuracionPozo->estado = $Pozo['estado'];
        $configuracionPozo->save();
        return $configuracionPozo;
    }


}
