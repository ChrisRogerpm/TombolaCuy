<?php

namespace App\Http\Controllers;

use App\Ubigeo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    public function UbigeoListarJson()
    {
        $lista = "";
        $mensaje_error = "";
        try {
            $lista = Ubigeo::UbigeoPaisListarJson();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['data' => $lista, 'mensaje' => $mensaje_error]);
    }
}
