<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TipoPago extends Model
{
    protected $table = 'tipo_pago';

    protected $primaryKey = 'idTipoPago';

    public $timestamps = false;

    public $fillable = ['nombre','multiplicadorDefecto', 'estado'];


    public static function TipoPagoListarJson()
    {
        $listar = TipoPago::all();
        return $listar;
    }

    public static function TipoPagoInsertarJson(Request $request)
    {
        $TipoPago = new TipoPago();
        $TipoPago->nombre = $request->input('nombre');
        $TipoPago->multiplicadorDefecto = $request->input('multiplicadorDefecto'); 
        $TipoPago->plenoMinimo = $request->input('plenoMinimo');
        $TipoPago->plenoMaximo = $request->input('plenoMaximo');
        $TipoPago->intercalado = $request->input('intercalado');
        $TipoPago->estado = 1;
        $TipoPago->save();
        return $TipoPago;
    }

    public static function TipoPagoEditarJson(Request $request)
    {
        $idTipoPago = $request->input('idTipoPago');
        $TipoPago = TipoPago::findorfail($idTipoPago);
        $TipoPago->nombre = $request->input('nombre');
        $TipoPago->multiplicadorDefecto = $request->input('multiplicadorDefecto'); 
        $TipoPago->plenoMinimo = $request->input('plenoMinimo');
        $TipoPago->plenoMaximo = $request->input('plenoMaximo');
        $TipoPago->intercalado = $request->input('intercalado');
        $TipoPago->estado = $request->input('estado');
        $TipoPago->save();
        return $TipoPago;
    }
}
