<?php

namespace App;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

class Reporte extends Model
{
    //
    //    protected $table = 'tipo_apuesta';
    //
    //    protected $primaryKey = 'idTipoApuesta';
    //
    //    public $timestamps = false;
    //
    //    public $fillable = ['idTipoPago' . 'valorapuesta', 'nombre', 'estado'];

    public static function ReporteApuestaJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $lista = DB::select(DB::raw("
        
        select p.nombre Tienda,ac.fechaoperacion,ac.idturno Turno,sum(t.montoTotal) apuestas,
        IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
        inner join apuesta a on a.idApuesta=ge.idApuesta
        inner join ticket ti on ti.idTicket=a.idTicket
        where t.idAperturaCaja= ac.idaperturacaja),0) Pagos,
        e.nombre Evento,count(t.idticket) Jugadores
        from apertura_caja ac
        inner join caja c on c.idCaja=ac.idCaja
        inner join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
        inner join ticket t on  t.idaperturacaja=ac.idaperturacaja
        inner join evento e on e.idevento=t.idevento 
        where  ac.estado!=0
        and c.idPuntoVenta in ($tiendas)
        and ac.fechaoperacion between '$fechaIni' and '$fechaFin'
        
        group by p.nombre,e.nombre,ac.fechaoperacion,ac.idturno,t.idAperturaCaja,ac.idAperturaCaja
        "));
        return $lista;

    }

    public static function ReporteHistorialGanadoresListarJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = Carbon::parse($request->input('fechaInicio'))->toDateString();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->toDateString();
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;

        $listar = DB::select(DB::raw("select p.nombre tienda,ac.fechaoperacion,ac.idturno Turno
          ,sum(t.montoTotal) apuestas
         ,IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
         inner join apuesta a on a.idApuesta=ge.idApuesta
         inner join ticket ti on ti.idTicket=a.idTicket
         where ti.idAperturaCaja= ac.idaperturacaja and ti.idEvento=e.idEvento ),0) Pagos
        ,
         e.idEVento Evento  ,count(t.idticket) Jugadores
         ,  IFNULL(( select count(ti.idTicket) from ganador_evento ge
         inner join apuesta a on a.idApuesta=ge.idApuesta
         inner join ticket ti on ti.idTicket=a.idTicket
         where ti.idAperturaCaja= ac.idaperturacaja and ti.idEvento=e.idEvento),0) totalganadores
         ,re.valorGanador ganador   , tia.rgb color, tip.nombre TipoApuesta  
           from apertura_caja ac
         inner join caja c on c.idCaja=ac.idCaja
         inner join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
         left join ticket t on  t.idaperturacaja=ac.idaperturacaja        
         left join evento e on e.idevento=t.idevento          
         left join resultado_evento re on re.idevento=e.idevento and re.idTipoPago in (1,6)
          left join tipo_apuesta tia on tia.idTipoApuesta=re.idTipoApuesta  and re.idTipoPago in (1,6)
           left join tipo_pago tip on tip.idTipoPago=tia.idTipoPago  
          where  ac.estado!=0
         and ac.fechaoperacion between '$fechaIni' and '$fechaFin'
         and c.idPuntoVenta in ($tiendas)       
       group by p.nombre,e.idEVento,ac.fechaoperacion,ac.idturno,re.valorGanador,ac.idAperturaCaja,t.idAperturaCaja,tia.rgb,tip.nombre"));

        return $listar;
    }

    public static function ReporteJackPotListarJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $jackPots = $request->input('jackPots');
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $jackPots = is_array($jackPots) ? implode(",", $jackPots) : $jackPots;

        $listar = DB::select(DB::raw("
        SELECT 
        caj.idPuntoVenta,
        pv.nombre tienda,
        eve.idEvento IdEvento,
        eve.nombre evento, 
        eve.fechaEvento fecha,
        tic.idTicket total_jugadores,
        tic.ganador total_ganadores,
        tic.montoTotal monto_total_apostado,
        apu.montoAPagar monto_total_pagado,
        tic.nroTicketParticipante NR_ticket_ganador,
        tpago.nombre tipo_de_apuesta,
        tapu.nombre valor_de_apuesta,
        tapu.rgb valor_apuesta_color_rgb
        from ganador_evento gev
        INNER JOIN apuesta apu on apu.idApuesta=gev.idApuesta
        INNER JOIN ticket tic on tic.idTicket=apu.idTicket
        INNER JOIN apertura_caja apc on apc.idAperturaCaja=tic.idAperturaCaja
        INNER JOIN caja caj on caj.idCaja=apc.idCaja
        INNER JOIN evento eve ON eve.idEvento = tic.idEvento
        INNER JOIN punto_venta pv ON pv.idPuntoVenta= caj.idPuntoVenta
        INNER JOIN tipo_apuesta tapu ON tapu.idTipoApuesta = apu.idTipoApuesta
        INNER JOIN tipo_pago tpago ON tpago.idTipoPago= tapu.idTipoPago
        "));
        return $listar;
    }

    public static function ConfiguracionPozoSegunConfJackPot(Request $request)
    {
        $idConfigJackPot = $request->input('idConfiguracionJackpot');

        $listar = DB::select(DB::raw("SELECT 
        j.idJackpot idJackPot,
        j.nombre JACKPOT,
        cj.idConfiguracionJackpot,
        cj.nombre

        FROM configuracion_jackpot cj
        INNER JOIN jackpot j ON j.idConfiguracionJackpot = cj.idConfiguracionJackpot
        WHERE cj.idConfiguracionJackpot=$idConfigJackPot
        
        "));
        return $listar;
    }

    public static function PozoJackPotSegunJackPotId(Request $request)
    {
        $idJackpot = $request->input('idJackpot');

        $listar = DB::select(DB::raw("SELECT
        j.idJackpot,
        j.nombre JackPot,
        pj.idPozoJackpot,
        pj.idJackpot,
        pj.idTicketGanador,
        pj.idMoneda,
        pj.numeroPozo,
        pj.montoBase,
        pj.montoBaseOculto,
        pj.incrementoJackpot,
        pj.incrementoPozoOculto,
        pj.limiteInferior,
        pj.limiteSuperior,
        pj.estado
        FROM jackpot j
        INNER JOIN pozo_jackpot pj ON pj.idJackpot= j.idJackpot
        WHERE j.idJackpot=$idJackpot
        "));
        return $listar;
    }

    public static function JackPotSegunidJackpot(Request $request)
    {
        $idJackpot = $request->input('idJackpot');


        // SELECT j.idJackpot,
        // j.nombre JackPot,
        // pv.idPuntoVenta,
        // pv.nombre TIENDA,
        //   pj.idPozoJackpot,    
        //   pj.incrementoJackpot,      	
        // pj.limiteInferior,
        // pj.limiteSuperior,
        // pj.incrementoPozoOculto,
        // pj.limiteInferiorOculto,
        // pj.limiteSuperiorOculto   
        // FROM jackpot j
        // INNER JOIN pozo_jackpot pj ON pj.idJackpot= j.idJackpot
        // INNER JOIN jackpot_punto_venta jpv ON jpv.idJackpot = j.idJackpot
        // INNER JOIN punto_venta pv ON pv.idPuntoVenta = jpv.idPuntoVenta
        // WHERE pj.idPozoJackpot=$idPozoJackpot

        $listar = DB::select(DB::raw("SELECT 
            j.idJackpot,
            j.nombre JackPot,
            pv.idPuntoVenta,
            pv.nombre TIENDA,
            pj.idPozoJackpot,      
            pj.incrementoJackpot,      	
            pj.limiteInferior,
            pj.limiteSuperior,
            pj.incrementoPozoOculto,
            pj.limiteInferiorOculto,
            pj.limiteSuperiorOculto     
            FROM jackpot j
            
            INNER JOIN pozo_jackpot pj ON pj.idJackpot= j.idJackpot
            INNER JOIN jackpot_punto_venta jpv ON jpv.idJackpot = j.idJackpot
            INNER JOIN punto_venta pv ON pv.idPuntoVenta = jpv.idPuntoVenta
                WHERE j.idJackpot=$idJackpot;
        "));
        return $listar;


    }

    public static function ReporteVenta(Request $request)
    {
        $fecha_ini = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fecha_fin = Carbon::parse($request->input('fechaFin'))->endOfDay();

//        $listar = DB::table('evento as e')
//            ->select('e.idEvento', 'e.fechaEvento AS Fecha', 'e.idEvento AS Evento', 'j.nombre AS Juego', 'm.codlso as Moneda', 'e.estadoEvento')
//            ->JOIN('juego as  j', 'j.idJuego', 'e.idJuego')
//            ->JOIN('moneda as m', 'm.idMoneda', 'e.idMoneda')
//            ->whereBetween('e.fechaEvento', array($fecha_ini, $fecha_fin))
//            ->get();

        $listar = DB::select(DB::raw("SELECT e.idEvento, e.fechaEvento AS Fecha, e.idEvento AS Evento, j.nombre AS Juego, m.codlso as Moneda,
         e.estadoEvento,ifnull(sum(t.montoTotal),0) - ifnull(sum(ge.montoAPagar),0) Ganado
        FROM evento e
        inner JOIN juego as j on j.idJuego = e.idJuego
        inner JOIN moneda AS m on m.idMoneda = e.idMoneda
        left join ticket t on t.idEvento=e.idevento 
        left join apuesta a on a.idTicket=t.idticket
        left join  ganador_evento ge on ge.idApuesta=a.idApuesta
        where e.fechaEvento between '$fecha_ini' and '$fecha_fin' and e.estadoEvento in (1,2)
        group by  e.idEvento, e.fechaEvento  , e.idEvento  , j.nombre  , m.codlso,  e.estadoEvento
        order by e.idevento desc"));

        return $listar;
    }

    public static function ValorGanadorEvento($idEvento)
    {
        $valorGanador = DB::table('resultado_evento as re')
            ->select('re.valorGanador')
            ->where('re.idEvento', $idEvento)
            ->groupBy('re.valorGanador')
            ->get();
        if (count($valorGanador) > 0) {
            return (int)$valorGanador[0]->valorGanador;
        } else {
            return '&&';
        }
    }

    public static function DescripcionResultadoEvento($idEvento)
    {
        $descripcion = DB::table('resultado_evento as re')
            ->select('ta.descripcion')
            ->join('tipo_apuesta as ta', 'ta.idTipoApuesta', 're.idTipoApuesta')
            ->join('tipo_pago as tp', 'tp.idTipoPago', 're.idTipoPago')
            ->where('re.idEvento', $idEvento)
            ->get();
        if (count($descripcion) > 0) {
            $resultado = "";
            foreach ($descripcion as $d) {
                $resultado .= $d->descripcion . ' / ';
            }
            return $resultado;
        } else {
            return '&&';
        }
    }

    public static function ReporteVentaJuego(Request $request)
    {
        $fecha_ini = $request->input('fechaInicio');
        $fecha_fin = $request->input('fechaFin');
        $IdJuego = $request->input('IdJuego');
        $valor_array = array();
        if ($fecha_ini == "" && $fecha_fin == "") {
            $listar = DB::table('evento as e')
                ->select('e.idEvento', 'e.fechaEvento')
                ->where('e.idJuego', $IdJuego)
                ->where('estadoEvento', 2)
                ->orderBy('e.idEvento', 'DESC')
                ->get();
            foreach ($listar as $l) {

                $valor = self::ValorGanadorEvento($l->idEvento);
                $descripcion = self::DescripcionResultadoEvento($l->idEvento);
                $valor_array [] = ['idEvento' => $l->idEvento, 'fechaEvento' => $l->fechaEvento, 'ValorGanador' => $valor, 'Descripcion' => $descripcion];
            }
        } else {
            $listar = DB::table('evento as e')
                ->select('e.idEvento', 'e.fechaEvento')
                ->where('e.idJuego', $IdJuego)
                ->whereBetween('e.fechaEvento', array($fecha_ini, $fecha_fin))
                ->where('estadoEvento', 2)
                ->orderBy('e.idEvento', 'DESC')
                ->get();
            foreach ($listar as $l) {
                $valor = self::ValorGanadorEvento($l->idEvento);
                $descripcion = self::DescripcionResultadoEvento($l->idEvento);
                $valor_array [] = ['idEvento' => $l->idEvento, 'fechaEvento' => $l->fechaEvento, 'ValorGanador' => $valor, 'Descripcion' => $descripcion];
            }
        }
        return $valor_array;
    }

    public static function ReporteCierreCaja()
    {
        $IdUsuario = Auth::user()->idUsuario;
        $resultado = DB::select(DB::raw("select ac.idAperturaCaja,idTurno,c.nombre caja,p.nombre puntoventa,ac.fechaOperacion,
         IFNULL(( select sum(t.montototal) from ticket t
         where t.idaperturacaja=ac.idaperturacaja),0) Venta,
         IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
         inner join apuesta a on a.idApuesta=ge.idApuesta
         inner join ticket t on t.idTicket=a.idTicket
         where t.idAperturaCaja= ac.idaperturacaja),0) Pagado
           from apertura_caja ac
         inner join caja c on c.idCaja=ac.idCaja
         inner join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
         where usuario=$IdUsuario and ac.estado=1"));
        return $resultado;
    }

    public static function ReporteHistorialTicket(Request $request)
    {

        $fecha_ini = $request->input('fechaInicio');
        $fecha_fin = $request->input('fechaFin');
        $tiendas = $request->input('tiendas');
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;

        $condicional = $tiendas == 0 ? "" : "and pv.idPuntoVenta in ($tiendas)";

        $resultado = DB::select(DB::raw("select e.nombre as 'juego',e.idEvento,e.fechaevento,ti.idticket,ti.montototal,ti.fechaRegistro,pv.nombre as 'puntoventa'  from ticket ti
        inner join evento e on e.idEvento=ti.idevento
        inner join apertura_caja ac on ac.idaperturacaja=ti.idaperturacaja
        inner join caja ca on ca.idcaja=ac.idcaja
        inner join punto_venta pv on pv.idpuntoventa=ca.idpuntoventa
        where ti.fechaRegistro between '$fecha_ini' and '$fecha_fin' and e.estadoEvento in (1,2)  $condicional"));
        //where ti.fe between '$fecha_ini' and '$fecha_fin' and e.estadoEvento in (1,2)
        return $resultado;
    }


}
