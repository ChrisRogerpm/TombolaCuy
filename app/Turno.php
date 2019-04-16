<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Turno extends Model
{
    protected $table = 'turno';

    protected $primaryKey = 'idTurno';

    public $timestamps = false;

    public $fillable = ['nombre', 'estado'];


    public static function TurnoListarJson()
    {
        $listar = Turno::all();
        return $listar;
    }

    public static function TurnoInsertarJson(Request $request)
    {
        $Turno = new Turno();
        $Turno->nombre = $request->input('nombre');
        $Turno->estado = 1;
        $Turno->save();
        return $Turno;
    }

    public static function TurnoEditarJson(Request $request)
    {
        $idTurno = $request->input('idTurno');
        $Turno = Turno::findorfail($idTurno);
        $Turno->nombre = $request->input('nombre');
        $Turno->estado = $request->input('estado');
        $Turno->save();
        return $Turno;
    }

    public static function TurnoObtenerId($IdTurno)
    {
        $resultado = Turno::findorfail($IdTurno);
        if ($resultado != null) {
            return $resultado->nombre;
        } else {
            return 'No existe';
        }
    }
}
