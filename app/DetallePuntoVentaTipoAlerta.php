<?php

namespace App;

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
}
