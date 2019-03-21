<?php

namespace App;


use App\ApiApuestaTotal\ValidarApi;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
//    use Notifiable;
//
//    protected $table = 'users';
//
//    protected $primaryKey = 'idUsuario';
//
//    public $timestamps = false;
//
//    protected $fillable = [
//        'usuario', 'password', 'remember_token'
//    ];
//
//    public static function ValidarTokenLogin($usuario, $password)
//    {
//        $validar_api = new ValidarApi();
//        $respuesta_api = $validar_api->ValidarLoginTokenApi($usuario, $password);
//        $respuesta_api = (string)$respuesta_api;
//        $respuesta = json_decode($respuesta_api, true);
//        return $respuesta;
//    }
//
//    public static function RegistrarUsuario($usuario, $password)
//    {
//        $user = new User();
//        $user->usuario = $usuario;
//        $user->password = bcrypt($password);
//        $user->save();
//        return $user;
//    }

}
