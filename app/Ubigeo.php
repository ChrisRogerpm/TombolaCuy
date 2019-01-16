<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = 'ubigeo';

    protected $primaryKey = 'idUbigeo';

    public $timestamps = false;

    public $fillable = ['PaisId', 'DepartamentoId', 'ProvinciaId', 'DistritoId','Nombre','fechaRegistro','Estado'];

    public static function UbigeoPaisListarJson()
    {
        $listar = DB::table('ubigeo')
            ->select('idUbigeo','Nombre')
            ->where('DepartamentoId','000')
            ->where('ProvinciaId','000')
            ->where('DistritoId','000')
            ->get();
        return $listar;
    }

}
