<?php

namespace App\Http\Controllers;

use App\ConfiguracionJackpot;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ConfiguracionJackpotController extends Controller
{
    public function ConfiguracionJackpotListarVista()
    {
        return view('ConfiguracionJackpot.ConfiguracionJackpotListarVista');
    }

    public function ConfiguracionJackpotInsertarVista()
    {
        return view('ConfiguracionJackpot.ConfiguracionJackpotInsertarVista');
    }

    public function ConfiguracionJackpotEditarVista($idConfiguracionJackpot)
    {
        return view('ConfiguracionJackpot.ConfiguracionJackpotEditarVista');
    }

    public function ConfiguracionJackpotListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = ConfiguracionJackpot::ConfiguracionJackpotListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}
