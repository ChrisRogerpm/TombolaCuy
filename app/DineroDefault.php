<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DineroDefault extends Model
{
    protected $table = 'dinero_default';

    protected $primaryKey = 'idDineroDefault';

    public $timestamps = false;


    public $fillable = ['monto', 'estado'];


    public static function DineroDefaultListarJson()
    {
        $listar = DineroDefault::all();
        return $listar;
    }

    public static function DineroDefaultInsertarJson(Request $request)
    {
        $DineroDefault = new DineroDefault();
        $DineroDefault->monto = $request->input('monto');
        $DineroDefault->estado = 1;
        $DineroDefault->save();
        return $DineroDefault;
    }

    public static function DineroDefaultEditarJson(Request $request)
    {
        $idDineroDefault = $request->input('idDineroDefault');
        $DineroDefault = DineroDefault::findorfail($idDineroDefault);
        $DineroDefault->monto = $request->input('monto');
        $DineroDefault->estado = $request->input('estado');
        $DineroDefault->save();
        return $DineroDefault;
    }
}
