<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class GanadorEvento extends Model
{
    protected $table = 'ganador_evento';

    protected $primaryKey = 'idGanadorEvento';

    public $timestamps = false;

    public $fillable = ['idApuesta', 'fechaPago','montoAPagar'];


    

    public static function GuardarGanadorEvento(Request $request)
    {
        $GanadorEvento = new GanadorEvento();
        $GanadorEvento->idApuesta = $request->input('idApuesta');
        $GanadorEvento->fechaPago = date('Y-m-d H:i:s');

        $montoAPagar=$request->input('montoApostado')*$request->input('multiplicadorApuestaGanada');
        $GanadorEvento->montoAPagar = $montoAPagar;
        $GanadorEvento->save();
        return $GanadorEvento;
    }


  
}
