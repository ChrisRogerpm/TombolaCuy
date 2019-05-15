<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class DetallePuntoVentaTipoAlerta extends Model
{
    protected $table = 'detalle_punto_venta_tipo_alerta';

    protected $primaryKey = 'idDetallePuntoVentaTipoAlerta';

    protected $fillable = [
        'idPuntoVentaTipoAlerta',
        'correoDestino',
        'estado'
    ];

    public $timestamps = false;

    public static function DetallePuntoVentaTipoAlertaObtenerId($idPuntoVentaTipoAlerta){
        $data = DB::table('detalle_punto_venta_tipo_alerta')
            ->where('idPuntoVentaTipoAlerta',$idPuntoVentaTipoAlerta)
            ->first();
        return $data;
    }
}
