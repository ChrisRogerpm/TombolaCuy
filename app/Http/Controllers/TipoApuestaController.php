<?php

namespace App\Http\Controllers;

use App\TipoApuesta;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TipoApuestaController extends Controller
{
	public function TipoApuestaListarVista()
	{
		return view('TipoApuesta.TipoApuestaListarVista');
	}
	public function TipoApuestaInsertarVista()
	{
		return view('TipoApuesta.TipoApuestaInsertarVista');
	}

	public function TipoApuestaEditarVista($idTipoApuesta)
	{
		$TipoApuesta = TipoApuesta::findorfail($idTipoApuesta);
		return view('TipoApuesta.TipoApuestaEditarVista', compact('TipoApuesta'));
	}
	public function TipoApuestaListarJson()
	{
		$lista = "";
		$mensaje_error = "";
		try {
			$lista = TipoApuesta::TipoApuestaListarJson();
		} catch (QueryException $ex) {
			$mensaje_error = $ex->errorInfo;
		}
		return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
	}
	public function TipoApuestaInsertarJson(Request $request)
	{
		$respuesta = false;
		$mensaje_error = "";
		try {
			TipoApuesta::TipoApuestaInsertarJson($request);
			$respuesta = true;
		} catch (QueryException $ex) {
			$mensaje_error = $ex->errorInfo;
		}
		return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
	}

	public function TipoApuestaEditarJson(Request $request)
	{
		$respuesta = false;
		$mensaje_error = "";
		try {
			TipoApuesta::TipoApuestaEditarJson($request);
			$respuesta = true;
		} catch (QueryException $ex) {
			$mensaje_error = $ex->errorInfo;
		}
		return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error]);
	}
}
