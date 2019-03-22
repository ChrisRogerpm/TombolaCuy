<?php

namespace App\Http\Controllers;

use App\Auditoria;
use App\Permisos;
use App\PermisosPerfil;
use App\Usuario;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Route;

class SeguridadController extends Controller
{
    public function PermisosUsuarioVista()
    {
        return view('Seguridad.PermisoUsuario');
    }

    public function PermisoPerfilListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista_Permisos = Permisos::PermisoListarJson();
            $lista_Perfil = PermisosPerfil::PermisoPerfilListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => [$lista_Permisos, $lista_Perfil], 'mensaje' => $mensaje_error]);
    }

    public function PermisoListarJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Permisos::PermisoListarJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function PermisoPerfilJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        $respuesta = false;
        try {
            $Permiso_perfil = PermisosPerfil::PermisoIDPerfilIDListarJson($request);
            //echo count($Permiso_perfil);exit();
            if (count($Permiso_perfil) > 0) {
                $eliminar = PermisosPerfil::PermisoPerfilActualizarJson($request);
                $respuesta = true;
            } else {
                $insertar = PermisosPerfil::PermisoPerfilInsertarJson($request);
                $respuesta = true;

            }
            $mensaje_error = 'Se Modifico Correctamente.';
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }
    public function ActualizarPerfilUsuario(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        $respuesta = false;
        try {
            $lista = Usuario::ActualizarPerfilJson($request);
            $mensaje_error = "Se Actualizo Correctamente.";
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function DataAuditoriaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Auditoria::DataAuditoriaJson($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    ///////permisos
    public function BarridoPermisos()
    {
        $respuesta = true;
        $mensaje_error = "Transaccion Realizada Correctamente.";
        try {
            //$eliminar = TblPermisos::PermisosLimpiar();
            $routeCollection = Route::getRoutes();

            $permisos_route_array = [];
            foreach ($routeCollection as $value) {
                array_push($permisos_route_array, $value->uri());
            }
            $permisos_route_array_BD = [];
            $listapermisos = Permisos::PermisoListarJson();
            foreach ($listapermisos as $value) {
                $nombrePermiso_DB = $value->nombre;
                $position = in_array($nombrePermiso_DB, $permisos_route_array);
                if (!$position) {
                    $eliminar_permiso_perfil = PermisosPerfil::PermisoPerfilIDEliminar($value->id);
                    $eliminar_permiso = Permisos::PermisosEliminar($value->id);
                } else {
                    array_push($permisos_route_array_BD, $nombrePermiso_DB);
                }
            }

            foreach ($routeCollection as $value) {
                $position = in_array($value->uri(), $permisos_route_array_BD);
                if (!$position) {
                    //echo $position;
                    $uri_entrante = $value->uri();
//                    if ($value->uri() !== "BarridoPermisos" || $value->uri() !== 'ValidarLoginJson' || $value->uri() !== "Login" || $value->uri() !== "ListdoUsuariosSelect" || $value->uri() !== "DataAuditoriaRegistro") {
                    $validar = strpos($uri_entrante, 'Fk');
                    if (!$validar) {
                        DB::table('permisos')->insertGetId(
                            [
                                'fecha_registro' => date('Y-m-d H:i:s'),
                                'nombre' => $value->uri(),
                                'controller' => $value->getActionName(),
                                'method' => $value->methods()[0],
                                'estado' => 1,
                            ]
                        );
                    }
                }

            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function BuscarPermiso(Request $request)
    {
        $respuesta = true;
        $mensaje_error = "No Tiene Permiso";
        try {
            $usuarioID = Auth::user()->idUsuario;
            $perfilID = Auth::user()->perfil_id;
            $currentRoute = Route::current()->uri();
            $permisoNombre = Permisos::PermisoNombre($currentRoute);
            $permisoID = 0;
            if (!is_null($permisoNombre)) {
                $permisoID = $permisoNombre->id;
            }
            if ($permisoID > 0) {
                $insertar_Auditoria = DB::table('auditoria')->insertGetId(
                    [
                        'fecha_registro' => date('Y-m-d H:i:s'),
                        'usuario_id' => $usuarioID,
                        'permiso' => Route::current()->uri(),
                        'controller' => Route::current()->getActionName(),
                        'method' => Route::current()->methods()[0],
                        'data' => json_encode($request->all()),
                    ]
                );

                $lista = PermisosPerfil::PermisoIDPerfilIDBuscarJson($permisoID, $perfilID);
                if (count($lista) > 0) {
                    $respuesta = true;
                } else {
                    $respuesta = false;
                }
            } else {
                $respuesta = false;
            }

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return $respuesta;
    }

    public function UsuarioListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Usuario::UsuarioListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}