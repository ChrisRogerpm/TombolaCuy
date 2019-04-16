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

	public function TipoPagoEditarVista($idTipoPago)
	{
		$TipoPago = TipoPago::findorfail($idTipoPago);
		return view('TipoPago.TipoPagoEditarVista', compact('TipoPago'));
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
	public function TipoPagoInsertarJson(Request $request)
	{
		$respuesta = false;
		$mensaje_error = "";
		try {
			TipoPago::TipoPagoInsertarJson($request);
			$respuesta = true;
		} catch (QueryException $ex) {
			$mensaje_error = $ex->errorInfo;
		}
		return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
	}

	public function TipoPagoEditarJson(Request $request)
	{
		$respuesta = false;
		$mensaje_error = "";
		try {
			TipoPago::TipoPagoEditarJson($request);
			$respuesta = true;
		} catch (QueryException $ex) {
			$mensaje_error = $ex->errorInfo;
		}
		return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
	}
}
