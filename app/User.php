<?php

namespace App;

use App\ApiApuestaTotal\Curl;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'idUsuario';

    public $timestamps = false;

    protected $fillable = [
        'usuario', 'password','remember_token'
    ];

    public static function ValidarTokenLogin($usuario, $password)
    {
        $credenciales = [
            'opt' => 'login',
            'source' => 'tombolaCuy',
            'usuario' => $usuario,
            'password' => md5($password),
        ];
        //Token para la Api
        $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
        $curl = new Curl($s3k_password);
        $respuesta_api = $curl->post($credenciales);

        return $respuesta_api;
    }

    public static function RegistrarUsuario($usuario, $password)
    {
        $user = new User();
        $user->usuario = $usuario;
        $user->password = bcrypt($password);
        $user->save();
        return $user;
    }

}
