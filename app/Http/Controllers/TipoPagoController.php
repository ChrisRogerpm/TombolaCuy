<?php

namespace App\Http\Controllers;

use App\TipoPago;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TipoPagoController extends Controller
{
    public function TipoPagoListarVista()
    {
        return view('TipoPago.TipoPagoListarVista');
    }
	public function TipoPagoInsertarVista()
    {
        return view('TipoPago.TipoPagoInsertarVista');
    }
    public function TipoPagoListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = TipoPago::TipoPagoListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}
