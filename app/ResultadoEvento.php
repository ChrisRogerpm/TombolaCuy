<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ResultadoEvento extends Model
{
    protected $table = 'resultado_evento';

    protected $primaryKey = 'idResultadosEvento';

    public $timestamps = false;

    public static function ValorGanadorEvento($idEvento)
    {
        $resultado = DB::table('resultado_evento')
            ->select('valorGanador')
            ->where('idEvento', $idEvento)
            ->groupBy('valorGanador')
            ->first();
        return $resultado;
    }

    public static function ResultadosEvento($IdJuego)
    {
        $eventoActivo = Evento::where('estadoEvento', 1)->first();

        $resultado = DB::table('resultado_evento as re')
            ->select('e.idEvento', 're.valorGanador','tipoapuesta.rgb')
            ->join('evento as e', 'e.idEvento', 're.idEvento')

            ->join('tipo_apuesta as tipoapuesta','tipoapuesta.idTipoApuesta','re.idTipoApuesta')
            
            ->where('e.idJuego', $IdJuego)
            ->where('re.estado', 1)
            ->whereIn('re.idTipoPago', array(1, 6))
            ->where('e.idEvento', '!=', $eventoActivo->idEvento)
            ->orderBy('re.idEvento', 'DESC')
            ->take(20)
            ->get();
        return $resultado;
    }

}
