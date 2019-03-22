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
        $maximo_evento = DB::select(DB::raw("SELECT MAX(et.idEvento) Maximo
        FROM evento et WHERE et.idJuego = $IdJuego"));

        $resultado = DB::table('resultado_evento as re')
            ->select('e.idEvento', 're.valorGanador')
            ->join('evento as e', 'e.idEvento', 're.idEvento')
            ->where('e.idJuego', $IdJuego)
            ->where('re.estado', 1)
            ->whereIn('re.idTipoPago', array(1, 6))
            ->where('e.idEvento', '<', $maximo_evento[0]->Maximo)
            ->orderBy('re.idEvento', 'DESC')
            ->take(20)
            ->get();
        return $resultado;
    }

}
