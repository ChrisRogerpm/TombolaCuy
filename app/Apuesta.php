<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Apuesta extends Model
{
    protected $table = 'apuesta';

    protected $primaryKey = 'idApuesta';

    public $timestamps = false;

    public $fillable = ['idTicket', 'idTipoApuesta','idMoneda','montoApostado','montoAPagar','ganador'];


    public static function ApuestaListarJson()
    {
        $listar = Apuesta::all();
        return $listar;
    }

    public static function GuardarApuestas($request)
    {
          $Apuesta = new Apuesta();
        $Apuesta->idTicket = $request['idTicket'];
        $Apuesta->idTipoApuesta = $request['idTipoApuesta'];
        $Apuesta->idMoneda = $request['idMoneda'];
        $Apuesta->montoApostado = $request['montoApostado'];
        $Apuesta->montoAPagar = 0;
        $Apuesta->ganador = 0;
        $Apuesta->save();
        return $Apuesta;
    }


}
