<?php

namespace App\Http\Controllers;

use App\ApiApuestaTotal\Curl;
use App\PuntoVenta;
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
            $request = [
                'opt' => 'data',
                'source' => 'locales',
            ];
            $s3k_password = "j3KJ0sdfldsKMmll0965Kwrfdml540QN";
            $curl = new Curl($s3k_password);

            $data = $curl->post($request);
            $data_result = $data['result'];

            foreach ($data_result as $data) {
                $cc_id = $data['cc_id'] == "" ? 0 : $data['cc_id'];
                $Nombre = $data['nombre'];

                if($cc_id != ""){
                    $validar = PuntoVenta::where('cc_id',$cc_id)->first();
                    if($validar == null){
                        $puntoventa = new PuntoVenta();
                        $puntoventa->nombre = $Nombre;
                        $puntoventa->cc_id = $cc_id;
                        $puntoventa->save();
                    }else{
                        $puntoventa = PuntoVenta::findorfail($validar->idPuntoVenta);
                        $puntoventa->nombre = $Nombre;
                        $puntoventa->cc_id = $cc_id;
                        $puntoventa->save();
                    }
                }
            }
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }

        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
    }

}
