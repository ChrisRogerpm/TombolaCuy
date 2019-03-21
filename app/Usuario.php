<?php

namespace App;

use App\ApiApuestaTotal\ValidarApi;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'idUsuario';

    public $timestamps = false;

    protected $fillable = [
        'usuario', 'password', 'perfil_id', 'remember_token','fecha_registro'
    ];

    public static function ValidarTokenLogin($usuario, $password)
    {
        $validar_api = new ValidarApi();
        $respuesta_api = $validar_api->ValidarLoginTokenApi($usuario, $password);
        $respuesta_api = (string)$respuesta_api;
        $respuesta = json_decode($respuesta_api, true);
        return $respuesta;
    }

    public static function RegistrarUsuario($usuario, $password)
    {
        $user = new User();
        $user->usuario = $usuario;
        $user->password = bcrypt($password);
        $user->fecha_registro = now();
        $user->save();
        return $user;
    }

    public static function ActualizarPerfilJson(Request $request)
    {
        DB::table('tbl_usuarios')->where('id', '=', $request->txtUsuarioID)->update(['perfil_id' => $request->txtPerfilID]);
        $respuesta = true;
        return $respuesta;
    }

    public static function UsuarioListarJson()
    {
        $listar = Usuario::all();
        return $listar;
    }
}
