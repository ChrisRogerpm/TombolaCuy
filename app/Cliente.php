<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cliente extends Model
{
    protected $table = 'Cliente';

    protected $primaryKey = 'idCliente';

    public $timestamps = false;

    public $fillable = ['nombres', 'apePaterno','apeMaterno','dni'];


    public static function ClienteListarJson()
    {
        $listar = Cliente::all();
        return $listar;
    }

    public static function ClienteInsertarJson(Request $request)
    {
        $Cliente = new Cliente();
        $Cliente->nombres = $request->input('nombres');
        $Cliente->apePaterno = $request->input('apePaterno');
        $Cliente->apeMaterno = $request->input('apeMaterno');
        $Cliente->dni = $request->input('dni');
        $Cliente->save();
        return $Cliente;
    }

    public static function ClienteEditarJson(Request $request)
    {
        $idCliente = $request->input('idCliente');
        $Cliente = Cliente::findorfail($idCliente);
        $Cliente->nombres = $request->input('nombres');
        $Cliente->apePaterno = $request->input('apePaterno');
        $Cliente->apeMaterno = $request->input('apeMaterno');
        $Cliente->dni = $request->input('dni');
        $Cliente->save();
        return $Cliente;
    }
}
