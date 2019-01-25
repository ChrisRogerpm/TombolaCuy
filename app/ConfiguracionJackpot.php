<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConfiguracionJackpot extends Model
{
    protected $table = 'configuracion_jackpot';

    protected $primaryKey = 'idConfiguracionJackpot';

    protected $fillable = ['nombre', 'superjackpot', 'estado'];

    public $timestamps = false;

    public static function ConfiguracionJackpotListar()
    {
        $listar = DB::table('configuracion_jackpot as c')
            ->select(
                'c.*',
                DB::raw("(select count(cp.idConfiguracionPozo) from configuracion_pozo as cp where cp.idConfiguracionJackpot = c.idConfiguracionJackpot) NroPozos"))
            ->get();

        return $listar;
    }

    public static function QueryNuub($wed)
    {
        $respuesta = ConfiguracionPozo::where('idConfiguracionJackpot', $wed)->count();
        return $respuesta;
    }

    public static function ConfiguracionJackpotInsertarJson(Request $request)
    {
        $configuracionJackpot = new ConfiguracionJackpot();
        $configuracionJackpot->nombre = $request->input('nombre');
        $configuracionJackpot->superjackpot = $request->input('superjackpot');
        $configuracionJackpot->estado = 1;
        $configuracionJackpot->save();
        return $configuracionJackpot->idConfiguracionJackpot;
    }

    public static function ConfiguracionJackpotEditarJson(Request $request)
    {
        $idConfiguracionJackpot = $request->input('idConfiguracionJackpot');
        $configuracionJackpot = ConfiguracionJackpot::findorfail($idConfiguracionJackpot);
        $configuracionJackpot->nombre = $request->input('nombre');
        $configuracionJackpot->superjackpot = $request->input('superjackpot');
        $configuracionJackpot->estado = $request->input('estado');
        $configuracionJackpot->save();
        return $configuracionJackpot->idConfiguracionJackpot;
    }

}
