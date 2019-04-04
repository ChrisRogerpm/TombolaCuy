<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TipoApuesta extends Model
{
    protected $table = 'tipo_apuesta';

    protected $primaryKey = 'idTipoApuesta';

    public $timestamps = false;

    public $fillable = ['idTipoPago' . 'valorapuesta', 'nombre', 'estado'];


    public static function TipoApuestaListarJson()
    {
        $listar = TipoApuesta::all();
        return $listar;
    }

    public static function TipoApuestaInsertarJson(Request $request)
    {
        $TipoApuesta = new TipoApuesta();


        $TipoApuesta->idTipoPago = $request->input('idTipoPago');
        $TipoApuesta->valorapuesta = $request->input('valorapuesta');
        $TipoApuesta->nombre = $request->input('nombre');

        $TipoApuesta->estado = 1;
        $TipoApuesta->save();
        return $TipoApuesta;
    }

    public static function TipoApuestaEditarJson(Request $request)
    {
        $idTipoApuesta = $request->input('idTipoApuesta');
        $TipoApuesta = TipoApuesta::findorfail($idTipoApuesta);
        $TipoApuesta->idTipoPago = $request->input('idTipoPago');
        $TipoApuesta->valorapuesta = $request->input('valorapuesta');
        $TipoApuesta->nombre = $request->input('nombre');
        $TipoApuesta->estado = $request->input('estado');
        $TipoApuesta->save();
        return $TipoApuesta;
    }

    public static function TipoApuestaColor($NumeroGenerado, $idEvento)
    {
        $tipo_apuesta = DB::table('tipo_apuesta as t')
            ->select('t.*', 'tp.multiplicadorDefecto')
            ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
            ->where('t.valorapuesta', '=', $NumeroGenerado)
            ->get();

        foreach ($tipo_apuesta as $apuesta) {
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $apuesta->valorapuesta;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }

        if ($NumeroGenerado % 2 == 0) {
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 43)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        } else {
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 44)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }
        if ($NumeroGenerado >= 1 && $NumeroGenerado <= 12) {
            //1-6
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 40)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }
        if ($NumeroGenerado >= 13 && $NumeroGenerado <= 24) {
            //1-6
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 41)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }
        if ($NumeroGenerado >= 25 && $NumeroGenerado <= 36) {
            //1-6
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 42)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }


        $color_valorGenerado = DB::table('tipo_apuesta as t')
            ->select('t.*', 'tp.multiplicadorDefecto')
            ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
            ->where('t.valorapuesta', '=', $NumeroGenerado)
            ->first();

        //Color 1
        if($color_valorGenerado->rgb == "#F9D716"){
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 37)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }
        //Color 2
        if($color_valorGenerado->rgb == "#16277D"){
            $apuesta = DB::table('tipo_apuesta as t')
                ->select('t.*', 'tp.multiplicadorDefecto')
                ->join('tipo_pago as tp', 'tp.idTipoPago', 't.idTipoPago')
                ->where('t.idTipoApuesta', '=', 38)
                ->first();
            $resultado = new ResultadoEvento();
            $resultado->idEvento = $idEvento;
            $resultado->multiplicadorApuestaGanada = $apuesta->multiplicadorDefecto;
            $resultado->valorGanador = $NumeroGenerado;
            $resultado->idTipoPago = $apuesta->idTipoPago;
            $resultado->estado = 1;
            $resultado->idTipoApuesta = $apuesta->idTipoApuesta;
            $resultado->save();
        }


    }


    public static function EstadisticaUltimosTipoApuesta()
    {
        $resultado = DB::table('resultado_evento as re')
            ->select('re.idEvento', 're.valorGanador')
            ->groupBy('re.idEvento', 're.valorGanador')
            ->orderBy('re.idEvento', 'DESC')
            ->take(120)
            ->get();
        $lista_valorapuesta = DB::table('tipo_apuesta as ta')
            ->select('ta.valorapuesta')
            ->whereIn('ta.idTipoPago', [1, 6])
            ->orderBy('ta.valorapuesta')
            ->get();
        $lista = [];
        foreach ($lista_valorapuesta as $va) {
            $lista_sub = [];
            foreach ($resultado as $r) {
                $lista_sub [] = $r->valorGanador;
            }
            $valores = array_count_values($lista_sub);
            $lista[] = [
                'TipoValorApuesta' => $va->valorapuesta,
                'Repetidos' => array_key_exists($va->valorapuesta, $valores) == false ? 0 : $valores[$va->valorapuesta]
            ];
        }
        return $lista;

    }
}
