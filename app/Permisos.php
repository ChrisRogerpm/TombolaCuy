<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Permisos extends Model
{
    protected $table = 'permisos';
    public $timestamps = false;

    protected $casts = [
        'tipo' => 'int',
        'estado' => 'int',

    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [

    ];

    public static function PermisoListarJson()
    {
        $listar = DB::table('permisos as tbl')
            ->select(
                'tbl.id',
                'tbl.tipo',
                'tbl.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.fecha_registro',
                'tbl.estado'
            )
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoNombre($nombre)
    {
        $listar = DB::table('permisos as tbl')
            ->select(
                'tbl.id',
                'tbl.tipo',
                'tbl.nombre',
                'tbl.controller',
                'tbl.method',
                'tbl.descripcion',
                'tbl.fecha_registro',
                'tbl.estado'
            )
            ->where('nombre',$nombre)
            ->first();
        return $listar;
    }
    public static function PermisosInsertarJson(Request $request)
    {
        $idPermisoUsuarioInsertado = DB::table('tbl_permisos')->insertGetId([
            'fecha_registro' => date('Y-m-d H:i:s'),
            'tipo' => $request->txtTipo,
            'nombre' => $request->txtNombre,
            'controller' => $request->txtController,
            'method' => $request->txtMethod,
            'descripcion' => $request->txtDescripcion,
            'estado' => 1,
        ]);
        return $idPermisoUsuarioInsertado;
    }

    public static function PermisosActualizarJson($permisosID)
    {
        DB::table('permisos')->where('id', '=',$permisosID)->first()->delete();
        $respuesta=true;
        return $respuesta;
    }

    public static function PermisosLimpiar()
    {
        DB::table('permisos')->where('id', '>',0)->delete();
        $respuesta=true;
        return $respuesta;
    }

    public static function PermisosEliminar($id)
    {
        DB::table('permisos')->where('id',$id)->delete();
        $respuesta=true;
        return $respuesta;
    }
}
