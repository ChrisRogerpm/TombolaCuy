<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TipoAlerta extends Model
{
    protected $table = 'tipo_alerta';

    protected $primaryKey = 'idTipoAlerta';

    protected $fillable = [
        'nombre',
        'monto',
        'estado',
    ];

    public $timestamps = false;

    public static function ListarTipoAlerta()
    {
        $lista = TipoAlerta::all();
        return $lista;
    }

    public static function RegistrarTipoAlerta(Request $request)
    {
        $tipo_alerta = new TipoAlerta();
        $tipo_alerta->nombre = $request->input('nombre');
        $tipo_alerta->monto = $request->input('monto');
        $tipo_alerta->estado = 1;
        $tipo_alerta->save();
    }

    public static function EditarTipoAlerta(Request $request)
    {
        $idTipoAlerta = $request->input('idTipoAlerta');
        $tipo_alerta = TipoAlerta::findorfail($idTipoAlerta);
        $tipo_alerta->nombre = $request->input('nombre');
        $tipo_alerta->monto = $request->input('monto');
        $tipo_alerta->estado = $request->input('estado');
        $tipo_alerta->save();
    }
}
