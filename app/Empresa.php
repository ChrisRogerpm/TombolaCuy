<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Empresa extends Model
{
    protected $table = 'empresa';

    protected $primaryKey = 'idEmpresa';

    public $timestamps = false;

    public $fillable = ['razonSocial', 'ruc', 'direccion', 'telefono'];


    public static function EmpresaListarJson()
    {
        $listar = Empresa::all();
        return $listar;
    }

    public static function EmpresaInsertarJson(Request $request)
    {
        $empresa = new Empresa();
        $empresa->razonSocial = $request->input('razonSocial');
        $empresa->ruc = $request->input('ruc');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->save();
        return $empresa;
    }

    public static function EmpresaEditarJson(Request $request)
    {
        $idEmpresa = $request->input('idEmpresa');

        $empresa = Empresa::findorfail($idEmpresa);
        $empresa->razonSocial = $request->input('razonSocial');
        $empresa->ruc = $request->input('ruc');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->save();
        return $empresa;
    }

}
