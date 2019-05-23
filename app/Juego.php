<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Juego extends Model
{
    protected $table = 'juego';

    protected $primaryKey = 'idJuego';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'logo',
        'lapsoProxEventoHoras',
        'lapsoProxEventoDia',
        'lapsoProxEventoMinutos',
        'apuestaMinima',
        'apuestaMaxima',
        'segBloqueoAntesEvento',
        'idMoneda',
        'diasVigentesCobroTicket',
        'estado',
        'segBloqueoAntesAnimacion',
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

    public static function JuegoEditarJson(Request $request)
    {
        $idJuego = $request->input('idJuego');
        $juego = Juego::findorfail($idJuego);
        $juego->apuestaMinima = $request->input('apuestaMinima');
        $juego->apuestaMaxima = $request->input('apuestaMaxima');
        $juego->save();
        Evento::ActualizarEventosNoActivos($idJuego);
    }
}
