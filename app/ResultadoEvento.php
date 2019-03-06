<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class ResultadoEvento extends Model
{
    protected $table = 'resultado_evento';

    protected $primaryKey = 'idResultadosEvento';

    public $timestamps = false;

    public static function ValorGanadorEvento($IdEvento)
    {

        $resultado = DB::table('resultado_evento')
            ->select('valorGanador')
            ->where('idEvento',$IdEvento)
            ->groupBy('valorGanador')
            ->first();
        return $resultado;
    }

    public static function UltimosResultadosEvento($IdJuego)
    {
        $ultimo_evento = Evento::UltimoEventoTerminado($IdJuego);
        $idvalor = $ultimo_evento->idEvento;
        $valor_ganador = ResultadoEvento::ValorGanadorEvento($idvalor);
        $resultado = DB::table('resultado_evento as re')
            ->join('evento as e', 'e.idEvento', 're.idEvento')
            ->where('e.idJuego', $IdJuego)
            ->where('re.valorGanador', $valor_ganador->valorGanador)
            ->take(20)
            ->orderBy('re.idResultadosEvento', 'DESC')
            ->get();
        return $resultado;
    }

}
