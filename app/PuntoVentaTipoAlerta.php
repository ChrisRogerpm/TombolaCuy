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

}
