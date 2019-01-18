<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionJackpot extends Model
{
    protected $table = 'configuracion_jackpot';

    protected $primaryKey = 'idConfiguracionJackpot';

    protected $fillable = ['nombre', 'superjackpot', 'estado'];

    public $timestamps = false;

    public static function ConfiguracionJackpotListar()
    {
        $listar = DB::select( DB::raw("select  c.idConfiguracionJackpot,c.nombre,(select count(cp.idConfiguracionPozo) from configuracion_pozo as cp 
                where cp.idConfiguracionJackpot = c.idConfiguracionJackpot) NroPozos,c.superjackpot,
                c.estado from configuracion_jackpot as c") );

        return $listar;
    }
}
