<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Hash;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AutenticacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['LoginVista']]);
    }

    public function LoginVista()
    {
        return view('Autenticacion.Login');
    }

    public function ValidarLoginJson(Request $request)
    {
        $usuario = $request->input('usuario');
        $password = $request->input('password');

        $respuesta = false;
        $mensaje_error = '';
        try {
            // $respuesta_api = User::ValidarTokenLogin($usuario, $password);

            // $http_code = $respuesta_api['http_code'];
            $http_code = 202;
            //$status = $respuesta_api['status'];

            if ($http_code == 202) {
                $validar = User::where('usuario', $usuario)->first();
                if ($validar == null) {
                    $credenciales = User::RegistrarUsuario($usuario, $password);
                    if (Auth::attempt(['usuario' => $usuario, 'password' => $password])) {
                        $respuesta = true;
                    }
                } else {
                    if (Auth::attempt(['usuario' => $usuario, 'password' => $password])) {
                        $respuesta = true;
                    }
                }
            } else if ($http_code == 401) {
                $intentos_fallidos = $respuesta_api['attempts_left'];
                if ($intentos_fallidos == 0) {
                    $mensaje_error = 'Sesión Deshabilitada ,Comuníquese con el Administrador';
                } else {
                    $mensaje_error = 'Usuario/Contraseña no Coincide, Tienes ' . $intentos_fallidos . ' Intento(s) mas';
                }
            }
            

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function CerrarSesionJson(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect('/');
        } else {
            return redirect('/');
        }

    }
}