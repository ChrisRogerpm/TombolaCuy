<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    public $timestamps = false;

    protected $casts = [
        'usuario_id' => 'int',

    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [

    ];

    public static function ReporteAuditoriaListarJson(Request $request)
    {
        $listar = DB::table('auditoria as tbl')
            ->select(
                'tbl.id',
                'tbl.fecha_registro',
                'tbl.usuario_id',
                'tbl.permiso',
                'usu.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.data'
            )
            ->join('tbl_usuarios as usu', 'usu.id','tbl.usuario_id')
            ->when($request->txtUsuario!='t', function($query,$idusuario){
                return $query->where('tbl.usuario_id', $idusuario);
            })
            ->whereBetween('tbl.fecha_registro', array(date('Y-m-d H:i:s',strtotime($request->txtFechaInicio)), date('Y-m-d H:i:s',strtotime($request->txtFechaFin))))
            ->orderBy('id', 'desc')
            ->get();
        return $listar;
    }

    public static function DataAuditoriaJson(Request $request)
    {
        $listar = DB::table('auditoria as tbl')
            ->select(
                'tbl.id',
                'tbl.fecha_registro',
                'tbl.usuario_id',
                'tbl.permiso',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.data'
            )
            ->where('tbl.id', '=',$request->txtAuditoriaID)
            ->first();
        return $listar;
    }
}
