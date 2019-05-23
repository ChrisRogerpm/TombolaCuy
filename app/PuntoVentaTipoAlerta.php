<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PuntoVentaTipoAlerta extends Model
{
    protected $table = 'punto_venta_tipo_alerta';

    protected $primaryKey = 'idPuntoVentaTipoAlerta';

    protected $fillable = [
        'idTipoAlerta',
        'idPuntoVenta',
        'monto'
    ];

    public $timestamps = false;


    public static function PuntoVentaTipoAlertaRegistrar(Request $request)
    {
        $puntoVentaTipoAlerta = new PuntoVentaTipoAlerta();
        $puntoVentaTipoAlerta->idTipoAlerta = $request->input('idTipoAlerta');
        $puntoVentaTipoAlerta->idPuntoVenta = $request->input('idPuntoVenta');
        $puntoVentaTipoAlerta->monto = $request->input('monto');
        $puntoVentaTipoAlerta->save();
    }

    public static function PuntoVentaTipoAlertaEditar(Request $request)
    {
        $idPuntoVentaTipoAlerta = $request->input('idPuntoVentaTipoAlerta');
        $correo = $request->input('correo');
        $puntoVentaTipoAlerta = PuntoVentaTipoAlerta::findorfail($idPuntoVentaTipoAlerta);
        $correo = is_array($correo) ? implode(",", $correo) : $correo;
        $idPuntoVenta = $request->input('puntoventa');
        $respuesta = PuntoVentaTipoAlerta::ValidarPuntoVentaTipoAlerta($idPuntoVenta, $puntoVentaTipoAlerta->idTipoAlerta);
        $resultado = false;
        if ($respuesta == null) {

            $TipoAlerta = TipoAlerta::findorfail($puntoVentaTipoAlerta->idTipoAlerta);
            $puntoVenta = PuntoVenta::PuntoVentaInfo($idPuntoVenta);
            $mensaje = str_replace("XXXXX", strtoupper($puntoVenta->nombre), $TipoAlerta->mensaje);
            $mensaje = str_replace("YYYYYY", strtoupper($request->input('monto')), $mensaje);


            //actualizar cabecera alerta punto venta
            $puntoVentaTipoAlerta->idPuntoVenta = $idPuntoVenta;
            $puntoVentaTipoAlerta->monto = $request->input('monto');
            $puntoVentaTipoAlerta->asunto = $request->input('asunto');
            $puntoVentaTipoAlerta->mensaje = $mensaje;
            $puntoVentaTipoAlerta->estado = $request->input('estado');
            $puntoVentaTipoAlerta->save();

            $detallepuntoventa = DetallePuntoVentaTipoAlerta::where('idPuntoVentaTipoAlerta', $idPuntoVentaTipoAlerta)->first();

            //actualizar detalle de cabecera
            $detalle_data = DetallePuntoVentaTipoAlerta::findorfail($detallepuntoventa->idDetallePuntoVentaTipoAlerta);
            $detalle_data->correoDestino = $correo;
            $detalle_data->save();
            $resultado = true;
        } else {
            $respuesta_idPuntoVentaTipoAlerta = $respuesta->idPuntoVentaTipoAlerta;
            if ($idPuntoVentaTipoAlerta == $respuesta_idPuntoVentaTipoAlerta) {

                $TipoAlerta = TipoAlerta::findorfail($puntoVentaTipoAlerta->idTipoAlerta);
                $puntoVenta = PuntoVenta::PuntoVentaInfo($idPuntoVenta);
                $mensaje = str_replace("XXXXX", strtoupper($puntoVenta->nombre), $TipoAlerta->mensaje);
                $mensaje = str_replace("YYYYYY", strtoupper($request->input('monto')), $mensaje);

                $puntoVentaTipoAlerta->idPuntoVenta = $idPuntoVenta;
                $puntoVentaTipoAlerta->monto = $request->input('monto');
                $puntoVentaTipoAlerta->asunto = $request->input('asunto');
                $puntoVentaTipoAlerta->mensaje = $mensaje;
                $puntoVentaTipoAlerta->estado = $request->input('estado');
                $puntoVentaTipoAlerta->save();
                $detallepuntoventa = DetallePuntoVentaTipoAlerta::where('idPuntoVentaTipoAlerta', $idPuntoVentaTipoAlerta)->first();
                //actualizar detalle de cabecera
                $detalle_data = DetallePuntoVentaTipoAlerta::findorfail($detallepuntoventa->idDetallePuntoVentaTipoAlerta);
                $detalle_data->correoDestino = $correo;
                $detalle_data->save();
                $resultado = true;
            }
        }

        return $resultado;
    }

    public static function ValidarPuntoVentaTipoAlerta($idPuntoVenta, $idTipoAlerta)
    {
        $data = DB::table('punto_venta_tipo_alerta')
            ->where('idTipoAlerta', $idTipoAlerta)
            ->where('idPuntoVenta', $idPuntoVenta)
            ->first();
        return $data;
    }


    public static function TipoAlertaPuntoVentaListar(Request $request)
    {
        $idTipoAlerta = $request->input('idTipoAlerta');

        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);

        $lista = DB::select(DB::raw("SELECT 
        pta.idPuntoVentaTipoAlerta,
        ta.nombre Alerta,
        pta.asunto,
        pta.mensaje,
        p.nombre PuntoVenta,
        pta.monto,
        pta.idPuntoVenta,
        (SELECT dpv.correoDestino FROM detalle_punto_venta_tipo_alerta dpv WHERE dpv.idPuntoVentaTipoAlerta = pta.idPuntoVentaTipoAlerta )Enviar,
        pta.estado
        FROM punto_venta_tipo_alerta pta
        JOIN punto_venta p ON p.idPuntoVenta = pta.idPuntoVenta
        JOIN tipo_alerta ta ON ta.idTipoAlerta = pta.idTipoAlerta
        WHERE pta.idTipoAlerta = $idTipoAlerta AND p.idPuntoVenta IN ($data)"));
        return $lista;
    }

    public static function TipoAlertaPuntoVentaInsertar(Request $request)
    {
        $idTipoAlerta = $request->input('idTipoAlerta');
        $idPuntoVenta = $request->input('idPuntoVenta');
        $correoDestino = $request->input('correoDestino');
        $correoDestino = is_array($correoDestino) ? implode(",", $correoDestino) : $correoDestino;
        $TipoAlerta = TipoAlerta::findorfail($idTipoAlerta);


        foreach ($idPuntoVenta as $pv) {

            $validar = PuntoVentaTipoAlerta::where('idPuntoVenta', $pv)->first();
            if ($validar == null) {
                $puntoVenta = PuntoVenta::PuntoVentaInfo($pv);
                $asunto = str_replace("XXXXX", strtoupper(' ' . $puntoVenta->nombre), $TipoAlerta->asunto);
                $mensaje = str_replace("XXXXX", strtoupper($puntoVenta->nombre), $TipoAlerta->mensaje);
                $mensaje = str_replace("YYYYYY", strtoupper($TipoAlerta->monto), $mensaje);
                $data = new PuntoVentaTipoAlerta();
                $data->idTipoAlerta = $idTipoAlerta;
                $data->idPuntoVenta = $pv;
                $data->monto = $TipoAlerta->monto;
                $data->asunto = $asunto;
                $data->mensaje = $mensaje;
                $data->estado = 1;
                $data->save();
                $data_detalle = new DetallePuntoVentaTipoAlerta();
                $data_detalle->idPuntoVentaTipoAlerta = $data->idPuntoVentaTipoAlerta;
                $data_detalle->correoDestino = $correoDestino;
                $data_detalle->estado = 1;
                $data_detalle->save();
            }
        }
    }

}
