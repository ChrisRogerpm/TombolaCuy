<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConfiguracionEvento extends Model
{
    protected $table = 'configuracion_evento';

    protected $primaryKey = 'idConfiguracionEvento';

    //protected $fillable = ['nombre', 'superjackpot', 'estado'];

    public $timestamps = false;

    public static function ConfiguracionEventoListar()
    {

        $listar = DB::select(DB::raw('select  * FROM Configuracion_Evento'));
        return $listar;


    }


    public static function EventoListar()
    {

        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
where ev.estadoEvento=1'));
        return $listar;


    }


}
