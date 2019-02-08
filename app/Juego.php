<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Juego extends Model
{
    protected $table = 'juego';

    protected $primaryKey = 'idJuego';

    protected $fillable = [
        'nombre',
        'logo',
        'lapsoProxEventoHoras',
        'lapsoProxEventoDia',
        'lapsoProxEventoDiaSemana',
        'lapsoProxEventoMinutos',
        'apuestaMinima',
        'apuestaMaxima',
        'segBloqueoAntesEvento',
        'idMoneda',
        'diasVigentesCobroTicket',
        'estado'
    ];

    public static function JuegoListarLapsoJson()
    {
        $listar = DB::table('juego as j')
            ->where('estado', 1)
            ->get();
        return $listar;
    }

    public static function JuegoEventoEjecucion($idJuego)
    {
        $evento = DB::table('evento')
            ->where('idJuego', $idJuego)
            ->where('estadoEvento', 1)
            ->first();

        return $evento;
    }

    public static function ActualizarEventoEjecucion($idEvento)
    {
        $respuesta = false;
        try {
            $evento = Evento::findorfail($idEvento);
            $evento->estadoEvento = 2;
            $evento->save();
            $respuesta = true;
        } catch (QueryException $ex) {
        }
        return $respuesta;
    }
}