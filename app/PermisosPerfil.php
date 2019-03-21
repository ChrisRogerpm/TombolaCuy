<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PermisosPerfil extends Model
{
    protected $table = 'permisos_perfil';
    public $timestamps = false;

    protected $casts = [
        'usuario_id' => 'int',
        'permiso_id' => 'int',

    ];

    protected $dates = [
        'fecha_registro'
    ];

    protected $fillable = [

    ];

    public static function PermisoPerfilListarJson(Request $request)
    {
        $listar = DB::table('permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
            )
            ->where('tbl.perfil_id', $request->txtPerfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoIDPerfilIDListarJson(Request $request)
    {
        $listar = DB::table('permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
            )
            ->where('tbl.permiso_id', $request->txtPermisoID)
            ->where('tbl.perfil_id', $request->txtPerfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }
    public static function PermisoPerfilInsertarJson(Request $request)
    {
        $idPermisoPerfilInsertado = DB::table('permisos_perfil')->insertGetId([
            'fecha_registro' => date('Y-m-d H:i:s'),
            'perfil_id' => $request->txtPerfilID,
            'permiso_id' => $request->txtPermisoID,
            'estado' => 1
        ]);
        return $idPermisoPerfilInsertado;
    }

    public static function PermisoPerfilActualizarJson(Request $request)
    {
        DB::table('permisos_perfil')->where('permiso_id', '=',$request->txtPermisoID)->where('perfil_id', '=',$request->txtPerfilID)->delete();
        $respuesta=true;
        return $respuesta;
    }

    public static function PermisoIDPerfilIDBuscarJson($permisoID,$perfilID)
    {
        $listar = DB::table('permisos_perfil as tbl')
            ->select(
                'tbl.id',
                'tbl.perfil_id',
                'tbl.permiso_id',
                'tbl.estado',
                'tbl.fecha_registro'
            )
            ->where('tbl.permiso_id', $permisoID)
            ->where('tbl.perfil_id', $perfilID)
            ->where('estado',1)
            ->get();
        return $listar;
    }

    public static function PermisoPerfilIDEliminar($id)
    {
        DB::table('permisos_perfil')->where('permiso_id',$id)->delete();
        $respuesta=true;
        return $respuesta;
    }
}
