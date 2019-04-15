<?php

namespace App\Http\Controllers;

use App\ApiApuestaTotal\Curl;
use App\ApiApuestaTotal\ValidarApi;
use App\PuntoVenta;
use App\Ubigeo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function PuntoVentaListarVista()
    {
        return view('PuntoVenta.PuntoVentaListarVista');
    }

    public function PuntoVentaInsertarVista()
    {
        return view('PuntoVenta.PuntoVentaInsertarVista');
    }

    public function PuntoVentaEditarVista($idPuntoVenta)
    {
        $PuntoVenta = PuntoVenta::findorfail($idPuntoVenta);
        return view('PuntoVenta.PuntoVentaEditarVista', compact('PuntoVenta'));
    }

    public function PuntoVentaListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function PuntoVentaListarUsuarioJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaListarUsuarioJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function PuntoVentaInsertarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            PuntoVenta::PuntoVentaInsertarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function PuntoVentaEditarJson(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            PuntoVenta::PuntoVentaEditarJson($request);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

    public function SincronizarPuntoVentaAPI()
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            $validar_api = new ValidarApi();
            $respuesta_api = $validar_api->ListaTiendasTokenApi();
            $respuesta_api = (string)$respuesta_api;
            $resp = json_decode($respuesta_api, true);
            $http_code = $resp['http_code'];
            if ($http_code == 200) {
                foreach ($resp['result'] as $data) {
                    $data_unit_ids = $data['unit_ids'];
                    $unit_ids = "";
                    $come = ",";
                    $ultimo_unit_id = "";
                    foreach ($data_unit_ids as $unit_id) {
                        $unit_ids .= $unit_id . $come;
                        $ultimo_unit_id = $unit_id;
                    }
                    $idUbigeo = Ubigeo::ObtenerDepartamento($ultimo_unit_id);
                    $idZonaComercial = Ubigeo::ObtenerZonaComercial($idUbigeo);
                    if ($data['cc_id'] != "") {
                        $validar = PuntoVenta::where('cc_id', $data['cc_id'])->first();
                        if ($validar == null) {
                            $puntoventa = new PuntoVenta();
                            $puntoventa->nombre = $data['nombre'];
                            $puntoventa->cc_id = $data['cc_id'];
                            $puntoventa->idUbigeo = $idUbigeo;
                            $puntoventa->unit_ids = $unit_ids;
                            $puntoventa->ZonaComercial = $idZonaComercial;
                            $puntoventa->save();
                        } else {
                            $puntoventa = PuntoVenta::findorfail($validar->idPuntoVenta);
                            $puntoventa->nombre = $data['nombre'];
                            $puntoventa->cc_id = $data['cc_id'];
                            $puntoventa->idUbigeo = $idUbigeo;
                            $puntoventa->unit_ids = $unit_ids;
                            $puntoventa->ZonaComercial = $idZonaComercial;
                            $puntoventa->save();
                        }
                    }
                }
                $respuesta = true;
            } else {
                $mensaje_error = "El servicio de Sincronización no esta disponible en estos momentos";
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

}
