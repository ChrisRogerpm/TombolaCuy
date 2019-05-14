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

    public $fillable = ['idTipoPago' . 'valorapuesta', 'nombre', 'estado', 'rgb', 'rgbLetra'];


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

        if ($NumeroGenerado % 2 == 0 && $NumeroGenerado != 0) {
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
        }
        if ($NumeroGenerado % 2 !== 0 && $NumeroGenerado != 0) {
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
        if ($color_valorGenerado->rgb == "#F9D716") {
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
        if ($color_valorGenerado->rgb == "#16277D") {
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

    public static function ValorGanadorRepetidos($ValorGanador, $IdJuego)
    {
        $lista = DB::select(DB::raw("SELECT 
        rev.idEvento,rev.valorGanador
        FROM resultado_evento rev
        JOIN evento e ON e.idEvento = rev.idEvento
        JOIN juego j ON j.idJuego = e.idJuego
        WHERE e.estadoEvento = 2 AND j.idJuego = $IdJuego
        GROUP BY rev.idEvento,rev.valorGanador
        ORDER BY rev.idEvento DESC
        LIMIT 120"));
        $lista_valores = [];
        foreach ($lista as $l) {
            $lista_valores [] = $l->valorGanador;
        }
        $total_coincidencias = array_count_values($lista_valores);
        $total = array_key_exists($ValorGanador, $total_coincidencias) == false ? 0 : $total_coincidencias[$ValorGanador];
        return $total;
    }

    public static function EstadisticaUltimosTipoApuesta($IdJuego)
    {
        $lista_valorapuesta = DB::table('tipo_apuesta as ta')
            ->select('ta.valorapuesta', 'ta.rgb', 'ta.rgbLetra')
            ->whereIn('ta.idTipoPago', [1, 6])
            ->orderBy('ta.valorapuesta')
            ->get();
        $lista = [];
        foreach ($lista_valorapuesta as $l) {
            $repetidos = TipoApuesta::ValorGanadorRepetidos($l->valorapuesta, $IdJuego);
            $lista [] = [
                'valorapuesta' => $l->valorapuesta,
                'rgb' => $l->rgb,
                'rgbLetra' => $l->rgbLetra,
                'Repetidos' => $repetidos
            ];
        }
        return $lista;
    }

    public static function TipoApuestaListar()
    {
        $lista_valorapuesta = DB::table('tipo_apuesta as ta')
            ->select('ta.valorapuesta', 'ta.rgb', 'ta.rgbLetra')
            ->whereIn('ta.idTipoPago', [1, 6])
            ->orderBy('ta.valorapuesta')
            ->get();
        return $lista_valorapuesta;
    }
}
