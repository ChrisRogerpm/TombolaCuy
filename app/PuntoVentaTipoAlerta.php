<?php

namespace App;

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
        $puntoVentaTipoAlerta = PuntoVentaTipoAlerta::findorfail($idPuntoVentaTipoAlerta);
        $puntoVentaTipoAlerta->idTipoAlerta = $request->input('idTipoAlerta');
        $puntoVentaTipoAlerta->idPuntoVenta = $request->input('idPuntoVenta');
        $puntoVentaTipoAlerta->monto = $request->input('monto');
        $puntoVentaTipoAlerta->save();
    }

    public static function TipoAlertaPuntoVentaInsertar(Request $request)
    {
        $idTipoAlerta = $request->input('idTipoAlerta');
        $idPuntoVenta = $request->input('idPuntoVenta');
        $correoDestino = $request->input('correoDestino');
        $TipoAlerta = TipoAlerta::findorfail($idTipoAlerta);
        foreach ($idPuntoVenta as $pv) {
            $data = new PuntoVentaTipoAlerta();
            $data->idTipoAlerta = $idTipoAlerta;
            $data->idPuntoVenta = $pv;
            $data->monto = $TipoAlerta->monto;
            $data->asunto = $TipoAlerta->asunto;
            $data->mensaje = $TipoAlerta->mensaje;
            $data->estado = 1;
            $data->save();
            foreach ($correoDestino as $correo) {
                $data_detalle = new DetallePuntoVentaTipoAlerta();
                $data_detalle->idPuntoVentaTipoAlerta = $data->idPuntoVentaTipoAlerta;
                $data_detalle->correoDestino = $correo;
                $data_detalle->estado = 1;
                $data_detalle->save();
            }
        }
    }

}
