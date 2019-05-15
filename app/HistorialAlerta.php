<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HistorialAlerta extends Model
{
    protected $table = 'historial_alerta';

    protected $primaryKey = 'idHistorialAlerta';

    protected $fillable = [
        'idPuntoVentaTipoAlerta',
        'fechaAlerta',
        'monto',
        'correos_envio',
        'estado_envio',
        'asunto',
        'mensaje'
    ];

    public $timestamps = false;


    public static function HistorialAlertaListar(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);
        $condicional = $tiendas == 0 ? "and pvt.idPuntoVenta IN ($data)" : "AND pvt.idPuntoVenta IN ($tiendas)";
        $lista = DB::select(DB::raw("SELECT 
        ha.idHistorialAlerta,
        pv.nombre,
        ha.fechaAlerta,
        ha.monto,
        ha.correos_envio,
        ha.estado_envio,
        ha.asunto,
        ha.mensaje
        FROM historial_alerta ha
        JOIN punto_venta_tipo_alerta pvt ON pvt.idPuntoVentaTipoAlerta = ha.idPuntoVentaTipoAlerta
        JOIN punto_venta pv ON pv.idPuntoVenta = pvt.idPuntoVenta
        WHERE ha.fechaAlerta BETWEEN '$fechaIni' AND '$fechaFin'
        $condicional 
        "));

        return $lista;
    }

    public static function HistorialAlertaVerificarEmail($idPuntoVentaTipoAlerta)
    {
        $data = DB::table('historial_alerta')
            ->where('idPuntoVentaTipoAlerta', $idPuntoVentaTipoAlerta)
            ->whereDate('fechaAlerta', now()->toDateString())
            ->first();
        return $data;
    }

    public static function HistorialAlertaRegistrar($obj)
    {
        $data = new HistorialAlerta();
        $data->idPuntoVentaTipoAlerta = $obj->idPuntoVentaTipoAlerta;
        $data->fechaAlerta = $obj->fechaAlerta;
        $data->monto = $obj->monto;
        $data->correos_envio = $obj->correos_envio;
        $data->estado_envio = $obj->estado_envio;
        $data->asunto = $obj->asunto;
        $data->mensaje = $obj->mensaje;
        $data->save();
    }
}
