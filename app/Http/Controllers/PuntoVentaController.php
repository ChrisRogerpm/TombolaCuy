<?php

namespace App\Http\Controllers;

use App\ApiApuestaTotal\Curl;
use App\ApiApuestaTotal\ValidarApi;
use App\PuntoVenta;
use App\Ubigeo;
use Auth;
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

    public function PuntoVentaListaGeneralJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $perfil_id = Auth::user()->perfil_id;
            if ($perfil_id == 0) {
                $lista = PuntoVenta::PuntoVentaListarJson();
            } else {
                $lista = PuntoVenta::PuntoVentaListarUsuarioJson();
            }

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
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

    public function PuntoVentaUsuarioAlertaJson(Request $request)
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = PuntoVenta::PuntoVentaUsuarioAlerta($request);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }

    public function SincronizarPuntoVentaAPI()
    {
        $respuesta = false;
        $mensaje_error = "";
        try {
            $rol_usuario = Auth::user()->perfil_id;
            if ($rol_usuario == 0) {
                $validar_api = new ValidarApi();
                $respuesta_api = $validar_api->ListaTiendasTokenApi();
                $respuesta_api = (string)$respuesta_api;
                $resp = json_decode($respuesta_api, true);
                $http_code = $resp['http_code'];
                if ($http_code == 200) {
                    foreach ($resp['result'] as $data) {
                        $data_unit_ids = $data['unit_ids'];
                        $unit_ids = "";
                        $ultimo_unit_id = "";
                        for ($i = 0; $i < count($data_unit_ids); $i++) {
                            $data_ultimo_indice = count($data_unit_ids) - 1;
                            if ($data_ultimo_indice == $i) {
                                $unit_ids .= $data_unit_ids[$i];
                                $ultimo_unit_id = $data_unit_ids[$i];
                            } else {
                                $unit_ids .= $data_unit_ids[$i] . ",";
                                $ultimo_unit_id = $data_unit_ids[$i];
                            }
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
            } else {
                $puntoventaUsuario = PuntoVenta::PuntoVentaListarUsuarioJson();
                if (count($puntoventaUsuario) > 0) {
                    foreach ($puntoventaUsuario as $pvu) {
                        $puntoventa = PuntoVenta::findorfail($pvu->idPuntoVenta);
                        $unit_ids = $puntoventa->unit_ids;
                        $unit_ids = explode(",", $unit_ids);
                        $ultimo_unit_id = "";
                        foreach ($unit_ids as $unt) {
                            $ultimo_unit_id = $unt;
                        }
                        $valor = new ValidarApi();
                        $resultado = $valor->consultarLocal($ultimo_unit_id);
                        $cc_id = $resultado['result']['cc_id'];
                        $nombre = $resultado['result']['nombre'];
                        $departamento = $resultado['result']['ubigeo_id'];
                        if (strlen($departamento) > 2) {
                            $departamento = substr($departamento, 0, 2);
                        }
                        $idUbigeo = Ubigeo::ObtenerIdUbigeoDepartamento($departamento);
                        if ($idUbigeo != null) {
                            $idUbigeo = $idUbigeo->idUbigeo;
                        }
                        $idZonaComercial = Ubigeo::ObtenerZonaComercial($idUbigeo);
                        $puntoventa->nombre = $nombre;
                        $puntoventa->cc_id = $cc_id;
                        $puntoventa->idUbigeo = $idUbigeo;
                        $puntoventa->ZonaComercial = $idZonaComercial;
                        $puntoventa->save();
                    }
                    $respuesta = true;
                }
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

}
