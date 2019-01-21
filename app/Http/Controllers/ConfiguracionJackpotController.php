<?php

namespace App\Http\Controllers;

use App\ConfiguracionJackpot;
use App\ConfiguracionPozo;
use DB;
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
        $ConfiguracionJackPot = ConfiguracionJackpot::findorfail($idConfiguracionJackpot);
        return view('ConfiguracionJackpot.ConfiguracionJackpotEditarVista', compact('ConfiguracionJackPot'));
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

    public function ConfiguracionJackpotInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            $IdConfiguracionJackpot = ConfiguracionJackpot::ConfiguracionJackpotInsertarJson($request);
            if ($IdConfiguracionJackpot > 0) {
                $ConfiguracionPozo = $request->input('pozo');
                foreach ($ConfiguracionPozo as $Pozo) {
                    ConfiguracionPozo::ConfiguracionPozoInsertarJson($Pozo, $IdConfiguracionJackpot);
                    $respuesta = true;
                }
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function ConfiguracionJackpotEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            $IdConfiguracionJackpot = ConfiguracionJackpot::ConfiguracionJackpotEditarJson($request);
            if ($IdConfiguracionJackpot > 0) {
                $ConfiguracionPozo = $request->input('pozo');
                foreach ($ConfiguracionPozo as $Pozo) {

                    if ($Pozo['idConfiguracionPozo'] > 0) {
                        ConfiguracionPozo::ConfiguracionPozoEditarJson($Pozo, $IdConfiguracionJackpot);
                        $respuesta = true;
                    } else {
                        ConfiguracionPozo::ConfiguracionPozoInsertarJson($Pozo, $IdConfiguracionJackpot);
                        $respuesta = true;
                    }

                }
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

}
