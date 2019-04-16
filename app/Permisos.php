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
            ->where('estado', 1)
            ->get();
        $data = [];
        foreach ($listar as $l) {
            $menu_controller = Permisos::GenerarMenusController($l->controller);
            $data[] = [
                'id' => $l->id,
                'tipo' => $l->tipo,
                'nombre' => $l->nombre,
                'controller' => $menu_controller,
                'method' => $l->method,
                'descripcion' => $l->descripcion,
                'fecha_registro' => $l->fecha_registro,
                'estado' => $l->estado,
            ];
        }

        return $data;
    }

    public static function GenerarMenusController($controller)
    {
        $_action = explode('@', $controller);
        $resultado = explode('Controller', explode('\\', $_action[0])[3])[0];
        return 'Menu ' . $resultado;
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
            ->where('nombre', $nombre)
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
        DB::table('permisos')->where('id', '=', $permisosID)->first()->delete();
        $respuesta = true;
        return $respuesta;
    }

    public static function PermisosLimpiar()
    {
        DB::table('permisos')->where('id', '>', 0)->delete();
        $respuesta = true;
        return $respuesta;
    }

    public static function PermisosEliminar($id)
    {
        DB::table('permisos')->where('id', $id)->delete();
        $respuesta = true;
        return $respuesta;
    }

    public static function AgregarPermisosTodos(Request $request)
    {
        $perfil_id = $request->input('perfil_id');
        $lista_permisos = DB::table('permisos')->get();
        $lista = DB::table('permisos_perfil')
            ->where('perfil_id', $request->input('perfil_id'))
            ->get();
        foreach ($lista as $l) {
            $permiso_perfil = PermisosPerfil::findorfail($l->id);
            $permiso_perfil->delete();
        }
        foreach ($lista_permisos as $l) {
            $permiso = new PermisosPerfil();
            $permiso->perfil_id = $perfil_id;
            $permiso->permiso_id = $l->id;
            $permiso->estado = 1;
            $permiso->fecha_registro = now();
            $permiso->save();
        }
    }

    public static function QuitarPermisosTodos(Request $request)
    {
        $lista = DB::table('permisos_perfil')
            ->where('perfil_id', $request->input('perfil_id'))
            ->get();
        foreach ($lista as $l) {
            $permiso_perfil = PermisosPerfil::findorfail($l->id);
            $permiso_perfil->delete();
        }
    }
}
