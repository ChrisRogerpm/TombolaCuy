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
    public static function ReporteApuestaJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = Carbon::parse($request->input('fechaInicio'))->startOfDay();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->endOfDay();
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);
        $condicional = $tiendas == 0 ? "and c.idPuntoVenta in ($data)" : "and c.idPuntoVenta in ($tiendas)";
        $lista = DB::select(DB::raw("select p.nombre Tienda,ac.fechaoperacion,ac.idturno Turno,IFNULL(sum(t.montoTotal),0) apuestas,
        IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
        inner join apuesta a on a.idApuesta=ge.idApuesta
        inner join ticket ti on ti.idTicket=a.idTicket
        where ti.idAperturaCajaPago= ac.idaperturacaja),0) Pagos,
        IFNULL(sum(t.montoTotal),0) -
        IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
        inner join apuesta a on a.idApuesta=ge.idApuesta
        inner join ticket ti on ti.idTicket=a.idTicket
        where ti.idAperturaCajaPago= ac.idaperturacaja),0) Utilidad,
        IFNULL(e.nombre,'CUY') Evento,count(t.idticket) Jugadores
        from apertura_caja ac
        left join caja c on c.idCaja=ac.idCaja
        left join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
        left join ticket t on  t.idaperturacaja=ac.idaperturacaja
        left join evento e on e.idevento=t.idevento 
        where  ac.estado!=0      
         $condicional
       and ac.fechaoperacion between '$fechaIni' and '$fechaFin'               
        group by p.nombre,e.nombre,ac.fechaoperacion,ac.idturno,t.idAperturaCaja, ac.idAperturaCaja
        order by ac.fechaoperacion,ac.idturno,p.nombre
        "));
        $data = [];
        foreach ($lista as $l) {
            $turno = Turno::TurnoObtenerId($l->Turno);
            $data [] = [
                'Tienda' => $l->Tienda,
                'Turno' => ucwords($turno),
                'apuestas' => $l->apuestas,
                'Pagos' => $l->Pagos,
                'Evento' => $l->Evento,
                'Jugadores' => $l->Jugadores,
                'fechaoperacion' => $l->fechaoperacion,
                'Utilidad' => $l->Utilidad,
            ];
        }
        return $data;

    }

    public static function ReporteHistorialGanadoresListarJson(Request $request)
    {
        $tiendas = $request->input('tiendas');
        $fechaIni = Carbon::parse($request->input('fechaInicio'))->toDateString();
        $fechaFin = Carbon::parse($request->input('fechaFin'))->toDateString();
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;

        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);

        $condicional = $tiendas == 0 ? "and c.idPuntoVenta in ($data)" : "and c.idPuntoVenta in ($tiendas)";

        $listar = DB::select(DB::raw("select p.nombre tienda,ac.fechaoperacion,ac.idturno Turno
          ,IFNULL(sum(t.montoTotal),0) apuestas
         ,IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
            inner join apuesta apu on apu.idApuesta=ge.idApuesta
          where apu.idTicket=IFNULL(t.idTicket,tpago.idTicket) ),0) Pagos       
        ,IFNULL( e.idEVento,epago.idEvento) Evento  ,count(t.idticket) Jugadores,
     	  IFNULL(( select count(ti.idTicket) from ganador_evento ge
         inner join apuesta a on a.idApuesta=ge.idApuesta
         inner join ticket ti on ti.idTicket=a.idTicket
         where ti.idAperturaCajaPago= ac.idaperturacaja and ti.idEvento=epago.idEvento),0) totalganadores
         ,IFNULL(re.valorGanador,repago.valorGanador) ganador   , IFNULL(tia.rgb,tiapago.rgb) color, IFNULL(tip.nombre,tippago.nombre) TipoApuesta  
           from apertura_caja ac
         inner join caja c on c.idCaja=ac.idCaja
         inner join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
         left join ticket t on  t.idaperturacaja=ac.idaperturacaja        
         left join evento e on e.idevento=t.idevento          
           left join ticket tpago on  tpago.idAperturaCajaPago=ac.idaperturacaja    
            left join evento epago on epago.idevento=tpago.idevento  
         left join resultado_evento re on re.idevento=e.idevento and re.idTipoPago in (1,6)
            left join resultado_evento repago on repago.idevento=epago.idevento and repago.idTipoPago in (1,6)
          left join tipo_apuesta tia on tia.idTipoApuesta=re.idTipoApuesta  and re.idTipoPago in (1,6)
             left join tipo_apuesta tiapago on tiapago.idTipoApuesta=repago.idTipoApuesta  and repago.idTipoPago in (1,6)
           left join tipo_pago tip on tip.idTipoPago=tia.idTipoPago  
               left join tipo_pago tippago on tippago.idTipoPago=tiapago.idTipoPago  
          where  ac.estado!=0
           and ac.fechaoperacion between '$fechaIni' and '$fechaFin' $condicional	 
       group by p.nombre,e.idEVento,epago.idEvento,ac.fechaoperacion,ac.idturno,re.valorGanador,repago.valorGanador,ac.idAperturaCaja,t.idAperturaCaja,tia.rgb,tiapago.rgb,tip.nombre,tippago.nombre
       ,tpago.idTicket,t.idTicket"));
        $data = [];
        foreach ($listar as $l) {
            $turno = Turno::TurnoObtenerId($l->Turno);
            $data [] = [
                'tienda' => $l->tienda,
                'fechaoperacion' => $l->fechaoperacion,
                'Turno' => ucwords($turno),
                'apuestas' => $l->apuestas,
                'Pagos' => $l->Pagos,
                'Evento' => $l->Evento,
                'Jugadores' => $l->Jugadores,
                'totalganadores' => $l->totalganadores,
                'ganador' => $l->ganador,
//                'color' => $l->color,
                'TipoApuesta' => $l->TipoApuesta,
            ];
        }
        return $data;
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
        AND j.estadoJackpot=1
        
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
        $puntoVenta = $request->input('PuntoVenta');
        $puntoVenta = is_array($puntoVenta) ? implode(",", $puntoVenta) : $puntoVenta;
        $ZonaComercial = $request->input('ZonaComercial');
        $ZonaComercial = is_array($ZonaComercial) ? implode(",", $ZonaComercial) : $ZonaComercial;

        $puntoventa_lista = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa_lista as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);

        $puntoventa_lista = is_array($data) ? implode(",", $data) : $data;

        $ZonaComercial = $ZonaComercial == 0 ? "and p.idPuntoVenta in ($puntoventa_lista)" : "and p.ZonaComercial in ($ZonaComercial)";
        $condicional = $puntoVenta == 0 ? $ZonaComercial : "and p.idPuntoVenta in ($puntoVenta)";

        $listar = DB::select(DB::raw("
        select 
         e.idEVento  Evento,
        concat('ZonaComercial ',IFNULL(p.ZonaComercial,0)) ZonaComercial ,
        p.nombre tienda,
           IFNULL(sum(t.montoTotal),0) - IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
        inner join apuesta apu on apu.idApuesta=ge.idApuesta
        inner join ticket tiint on tiint.idTicket=apu.idTicket                  
        where tiint.idEvento= e.idEVento  ),0) Ganado,
         e.fechaEvento  Fecha
        , j.nombre AS Juego, m.simbolo as Moneda,
         IFNULL(sum(t.montoTotal),0) - IFNULL(( select sum(ge.montoAPagar) from ganador_evento ge
        inner join apuesta apu on apu.idApuesta=ge.idApuesta
        inner join ticket tiint on tiint.idTicket=apu.idTicket                  
        where tiint.idEvento=e.idEVento ),0) Ganado, e.idEVento  Evento  ,  e.estadoEvento  estadoEvento     
        from apertura_caja ac
        LEFT join caja c on c.idCaja=ac.idCaja
        left join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
        left join ticket t on  t.idaperturacaja=ac.idaperturacaja        
        left join evento e on e.idevento=t.idevento          
        left join ticket tpago on  tpago.idAperturaCajaPago=ac.idaperturacaja           
        inner JOIN juego as j on j.idJuego = e.idJuego 
        inner JOIN moneda AS m on m.idMoneda = e.idMoneda  
        where  ac.estado!=0
        and  e.fechaEvento  between '$fecha_ini' AND '$fecha_fin'
        $condicional
        group by p.nombre,e.idEVento, ac.fechaoperacion,ac.idturno ,ac.idAperturaCaja,t.idAperturaCaja, e.estadoEvento , j.nombre , m.simbolo,p.ZonaComercial,e.fechaEvento 
        order by 2,3,1"));

        $data = [];

        foreach ($listar as $l) {
            $estadoEventoNombre = Reporte::EstadoEventoNombre($l->estadoEvento);
            $data [] = [
                'Fecha' => $l->Fecha,
                'ZonaComercial' => $l->ZonaComercial,
                'Tienda' => $l->tienda,
                'Juego' => $l->Juego,
                'Evento' => $l->Evento,
                'TipoApuesta' => 'Pleno',
                'Moneda' => $l->Moneda,
                'Ganado' => $l->Ganado,
                'estadoEvento' => $estadoEventoNombre
            ];
        }

        return $data;
    }

    public static function EstadoEventoNombre($estadoEvento)
    {
        $respuesta = "";
        if ($estadoEvento === 0) {
            $respuesta = "Anulado";
        } else if ($estadoEvento === 1) {
            $respuesta = "Ejecucion";
        } else if ($estadoEvento === 2) {
            $respuesta = "Terminado";
        } else if ($estadoEvento === 3) {
            $respuesta = "PendPago";
        } else if ($estadoEvento === 4) {
            $respuesta = "Pagado";
        } else if ($estadoEvento === 5) {
            $respuesta = "Suspendido";
        }
        return $respuesta;
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
            $listar = DB::select(DB::raw("SELECT re.idEvento,e.fechaEvento,ta.rgb,ta.rgbLetra,re.valorGanador
                    FROM resultado_evento re
                    JOIN evento e ON e.idEvento = re.idEvento
                    JOIN tipo_apuesta ta ON ta.idTipoApuesta = re.idTipoApuesta
                    where e.fechaEvento >= DATE_SUB(CURDATE(), INTERVAL 2 DAY)
                    AND e.idJuego = $IdJuego AND e.estadoEvento = 2
                    GROUP BY re.idEvento,re.valorGanador
                    ORDER BY re.idEvento desc"));
            foreach ($listar as $l) {
                $valor = self::ValorGanadorEvento($l->idEvento);
                $descripcion = self::DescripcionResultadoEvento($l->idEvento);
                $valor_array [] = [
                    'idEvento' => $l->idEvento,
                    'fechaEvento' => $l->fechaEvento,
//                    'rgb' => $l->rgb,
//                    'rgb_letra' => $l->rgbLetra,
                    'ValorGanador' => $valor,
                    'Descripcion' => $descripcion];
            }
        } else {
            $listar = DB::select(DB::raw("SELECT re.idEvento,e.fechaEvento,ta.rgb,ta.rgbLetra,re.valorGanador
                    FROM resultado_evento re
                    JOIN evento e ON e.idEvento = re.idEvento
                    JOIN tipo_apuesta ta ON ta.idTipoApuesta = re.idTipoApuesta
                    where e.fechaEvento BETWEEN '$fecha_ini' AND '$fecha_fin'
                    AND e.idJuego = $IdJuego AND e.estadoEvento = 2
                    GROUP BY re.idEvento,re.valorGanador
                    ORDER BY re.idEvento desc"));
            foreach ($listar as $l) {
                $valor = self::ValorGanadorEvento($l->idEvento);
                $descripcion = self::DescripcionResultadoEvento($l->idEvento);
                $valor_array [] = [
                    'idEvento' => $l->idEvento,
                    'fechaEvento' => $l->fechaEvento,
//                    'rgb' => $l->rgb,
//                    'rgb_letra' => $l->rgbLetra,
                    'ValorGanador' => $valor,
                    'Descripcion' => $descripcion];
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
        where t.idAperturaCajaPago= ac.idaperturacaja),0) Pagado 
        from apertura_caja ac
        inner join caja c on c.idCaja=ac.idCaja
        inner join punto_venta p on p.idPuntoVenta=c.idPuntoVenta
        where usuario= $IdUsuario  AND ac.estado=1"));
        return $resultado;
    }

    public static function ReporteHistorialTicket(Request $request)
    {

        $fecha_ini = $request->input('fechaInicio');
        $fecha_fin = $request->input('fechaFin');
        $tiendas = $request->input('tiendas');
        $idEvento = $request->input('idEvento');
        $TipoTicket = $request->input('TipoTicket');
        $tiendas = is_array($tiendas) ? implode(",", $tiendas) : $tiendas;
        $puntoventa = PuntoVenta::PuntoVentaListarUsuarioJson();
        $data = [];
        foreach ($puntoventa as $l) {
            $data [] = $l->idPuntoVenta;
        }
        $data = implode(",", $data);
        $condicional = "";
        if ($tiendas === null) {
            return [];
        }
        if ($tiendas == 0) {
            $condicional = "and pv.idPuntoVenta in ($data)";
        }
        if ($tiendas != 0 && $tiendas != null) {
            $condicional = "and pv.idPuntoVenta in ($tiendas)";
        }

        $condicional2 = $idEvento == "" ? "" : "and e.idEvento = $idEvento";
        $TipoTicket = $TipoTicket == null ? "0" : $TipoTicket;

        $resultado = DB::select(DB::raw("select 
        e.fechaevento,
        e.nombre as 'juego',
        e.idEvento,        
        ti.idticket,
        ti.fechaRegistro fechaApuesta,
        pv.nombre as 'puntoventa',
        IFNULL( ti.fechapago,ti.fechaRegistro) fechapago,
        IFNULL(pvpago.nombre,'-') as 'puntoventapago', 
        ti.montototal apostado,
    	IFNULL((select sum(ge.montoAPagar) from ganador_evento ge 
        inner join apuesta apu on apu.idApuesta=ge.idApuesta
        where apu.idTicket=ti.idTicket),0) pagado,
          ti.montototal -
    	IFNULL((select sum(ge.montoAPagar) from ganador_evento ge 
        inner join apuesta apu on apu.idApuesta=ge.idApuesta
        where apu.idTicket=ti.idTicket),0) utilidad,
        (select GROUP_CONCAT(ta.descripcion SEPARATOR '|') 
        from tipo_apuesta ta inner join  apuesta apu
        on ta.idtipoapuesta=apu.idtipoapuesta
        where apu.idticket=ti.idticket) valores
        from ticket ti
        left join evento e on e.idEvento=ti.idevento
        left join apertura_caja ac on ac.idaperturacaja=ti.idaperturacaja
        left join caja ca on ca.idcaja=ac.idcaja
        left join punto_venta pv on pv.idpuntoventa=ca.idpuntoventa
        left join apertura_caja acpago on acpago.idaperturacaja=ti.idAperturaCajaPago
        left join caja capago on capago.idcaja=acpago.idcaja
        left join punto_venta pvpago on pvpago.idpuntoventa=capago.idpuntoventa        
         where ti.fechaRegistro between '$fecha_ini' and '$fecha_fin' and e.estadoEvento in (2)  
         $condicional
         $condicional2
         "));
        $lista = [];
        foreach ($resultado as $re) {
            $estadoGanador = Reporte::VerificarEstadoGanadorTicket($re->idticket);
            if ($TipoTicket == 0) {
                if ($estadoGanador) {
                    $estado = "Ganador";
                } else {
                    $estado = "No Ganador";
                }
                $lista [] = [
                    'fechaevento' => $re->fechaevento,
                    'juego' => $re->juego,
                    'idEvento' => $re->idEvento,
                    'idticket' => $re->idticket,
                    'fechaApuesta' => $re->fechaApuesta,
                    'puntoventa' => $re->puntoventa,
                    'fechapago' => $re->fechapago,
                    'puntoventapago' => $re->puntoventapago,
                    'apostado' => $re->apostado,
                    'pagado' => $re->pagado,
                    'utilidad' => $re->utilidad,
                    'valores' => $re->valores,
                    'estadoGanadorTicket' => $estado
                ];
            } else if ($TipoTicket == 1 and $estadoGanador == true) {
                $estado = "Ganador";
                $lista [] = [
                    'fechaevento' => $re->fechaevento,
                    'juego' => $re->juego,
                    'idEvento' => $re->idEvento,
                    'idticket' => $re->idticket,
                    'fechaApuesta' => $re->fechaApuesta,
                    'puntoventa' => $re->puntoventa,
                    'fechapago' => $re->fechapago,
                    'puntoventapago' => $re->puntoventapago,
                    'apostado' => $re->apostado,
                    'pagado' => $re->pagado,
                    'utilidad' => $re->utilidad,
                    'valores' => $re->valores,
                    'estadoGanadorTicket' => $estado
                ];
            } else if ($TipoTicket == 2 and $estadoGanador == false) {
                $estado = "No Ganador";
                $lista [] = [
                    'fechaevento' => $re->fechaevento,
                    'juego' => $re->juego,
                    'idEvento' => $re->idEvento,
                    'idticket' => $re->idticket,
                    'fechaApuesta' => $re->fechaApuesta,
                    'puntoventa' => $re->puntoventa,
                    'fechapago' => $re->fechapago,
                    'puntoventapago' => $re->puntoventapago,
                    'apostado' => $re->apostado,
                    'pagado' => $re->pagado,
                    'utilidad' => $re->utilidad,
                    'valores' => $re->valores,
                    'estadoGanadorTicket' => $estado
                ];
            }
        }
        return $lista;
    }

    public static function VerificarEstadoGanadorTicket($idTicket)
    {
        $ticket = Ticket::where('idTicket', $idTicket)->first();
        $IdEvento = $ticket->idEvento;
        $valores_apostados = Apuesta::where('idTicket', $idTicket)->get();
        $respuesta = false;
        foreach ($valores_apostados as $va) {
            $coincidencia_ganador = DB::table('resultado_evento as re')
                ->where('re.idEvento', $IdEvento)
                ->where('re.idTipoApuesta', $va->idTipoApuesta)
                ->count();
            if ($coincidencia_ganador > 0) {
                $respuesta = true;
                break;
            }
        }
        return $respuesta;
    }

    public static function ReporteAuditoriaListarJson(Request $request)
    {
        $listar = DB::select(DB::raw("SELECT tbl.id,
                 tbl.fecha_registro,
                 tbl.usuario_id,
                 tbl.permiso,
                 usu.usuario,
                 tbl.controller,
                 tbl.method,
                 tbl.descripcion,
                 tbl.data
                FROM auditoria tbl
                JOIN users usu ON usu.idUsuario = tbl.usuario_id
                WHERE tbl.usuario_id = $request->UsuarioId AND tbl.fecha_registro BETWEEN '$request->txtFechaInicio' AND '$request->txtFechaFin' 
                ORDER BY tbl.id desc
                "));

        return $listar;
    }


}
