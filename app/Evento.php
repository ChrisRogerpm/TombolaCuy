<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class Evento extends Model
{
    protected $table = 'evento';

    protected $primaryKey = 'idEvento';

    protected $fillable = [
        'idJuego',
        'nombre',
        'fechaEvento',
        'fechaFinEvento',
        'apuestaMinima',
        'apuestaMaxima',
        'fechaEventoReprogramacion',
        'idMoneda',
        'estadoEvento',
        'estadoAnimacion',
        'tokenAnimacion',
        'puntosCuy',
        'segCajaGirando'
    ];

    public $timestamps = false;

    public static function EventoListar()
    {
        $listar = DB::select(DB::raw('
select ev.idEvento,ev.idJuego,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1'));
        return $listar;
    }

    public static function EventoDatosListar($idPuntoVenta)
    {
        $listar = DB::select(DB::raw('
 select 
(select  COUNT(*)  as cantidadganadores FROM ticket WHERE idEvento=ev.idEvento) as jugador,
(select mon.simbolo as simbolo  FROM evento ev2 left join moneda mon on mon.idMoneda=ev2.idMoneda WHERE ev2.idEvento=ev.idEvento ) as divisa,
(select   IFNULL(sum(POL.montoActual),0) as sumajackpots FROM pozo_online POL
            INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
            INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
            INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
            WHERE JPV.idPuntoVenta= ' . $idPuntoVenta . ') as jackpotsuma,
ev.idEvento,ev.idJuego,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento,ju.logo as logo,ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1 and ju.estado=1'));
        return $listar;
    }


    public static function EventoId($idEvento)
    {

        $listar = DB::select(DB::raw('select ev.idEvento,ev.nombre as nombre, ev.FechaEvento as FechaEvento, ev.fechaFinEvento  as fechaFinEvento, ju.logo as logo,
            ju.segBloqueoAntesEvento as segBloqueoAntesEvento,ev.idMoneda,
ev.apuestaMinima as apuestaMinima, ev.apuestaMaxima as apuestaMaxima    
from evento ev
left join juego ju on ju.idJuego= ev.idJuego
where ev.estadoEvento=1 and idEvento=' . $idEvento));
        return $listar;
    }

    public static function CantidadGanadorEventoListar($idEvento)
    {
        $listar = DB::select(DB::raw("select  COUNT(*)  as cantidadganadores FROM ticket WHERE idEvento =" . $idEvento));
        return $listar;
    }

    public static function SimboloEvento($idEvento)
    {
        $listar = DB::select(DB::raw("select mon.simbolo as simbolo  FROM evento ev left join moneda mon on mon.idMoneda=ev.idMoneda WHERE IDEVENTO =" . $idEvento));
        return $listar;
    }

    public static function JugadorDatosJson($idEvento)
    {
        $listar = DB::select(DB::raw("select  POL.montoActual FROM pozo_online POL
            INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
            INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
            INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
            WHERE JPV.idPuntoVenta=1
            "));
        return $listar;
    }

    public static function JackPotEvento($idPuntoVenta)
    {
        $listar = DB::select(DB::raw("select  POL.montoActual FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=" . $idPuntoVenta . "
			"));
        return $listar;
    }

    public static function JackPotSumaEvento($idPuntoVenta)
    {
        $listar = DB::select(DB::raw("select   IFNULL(sum(POL.montoActual),0) as sumajackpots FROM pozo_online POL
			INNER JOIN pozo_jackpot PZJ ON PZJ.idPozoJackpot=POL.idPozoJackpot
			INNER JOIN jackpot JACK ON JACK.idJackpot=PZJ.idJackpot
			INNER JOIN jackpot_punto_venta JPV ON JPV.idJackpot=JACK.idJackpot
			WHERE JPV.idPuntoVenta=" . $idPuntoVenta . "
			"));
        return $listar;
    }


    public static function HistorialEvento($ideventoactual)
    {
        $listar = DB::select(DB::raw("select evt.idEvento, res.`valorGanador`,tipo_apuesta.rgb as color
         FROM  `resultado_evento` res
inner join evento evt on res.`idEvento`=evt.`idEvento`
left join tipo_apuesta on tipo_apuesta.idTipoApuesta=res.idTipoApuesta
WHERE  
 evt.idJuego=(select even.idJuego from evento as even where even.idEvento=" . $ideventoactual . ")

and (tipo_apuesta.idTipoPago in (1,6) ) 
and evt.idEvento!=" . $ideventoactual . "  and evt.estadoEvento=2
order by evt.`fechaEvento` DESC
LIMIT 18
            "));
        return $listar;
    }

    public static function TipoApuestaListar()
    {
        $listar = DB::select(DB::raw("
        select tip_apu.valorapuesta,
 tip_apu.idTipoApuesta ,
 tip_apu.nombre,
 tip_apu.rgb, 
 FLOOR(tip_pag.multiplicadorDefecto) as multiplicadorDefecto,
  tip_pag.idTipoPago,
 tip_pag.plenoMinimo,
 tip_pag.plenoMaximo,tip_pag.intercalado
  from tipo_apuesta tip_apu LEFT JOIN tipo_pago tip_pag on tip_pag.idTipopago= tip_apu.idTipoPago"));
        return $listar;
    }

    public static function DineroDefaultListar()
    {
        $listar = DB::select(DB::raw("select * from dinero_default where estado =1"));
        return $listar;
    }

    public static function RegistrarEvento($juego, $fechaIni, $fechaEventoFin,$posiciones)
    {
        $token_generado = str_random(8);
        $evento = new Evento();
        $evento->idJuego = $juego->idJuego;
        $evento->nombre = $juego->nombre;
        $evento->fechaEvento = $fechaIni;
        $evento->fechaFinEvento = $fechaEventoFin;
        $evento->apuestaMinima = $juego->apuestaMinima;
        $evento->apuestaMaxima = $juego->apuestaMaxima;
        $evento->idMoneda = $juego->idMoneda;
        $evento->estadoEvento = 0;
        $evento->estadoAnimacion = 0;
        $evento->tokenAnimacion = $token_generado;
        $evento->puntosCuy = json_encode($posiciones);
        $evento->save();
        return $evento;
    }

    public static function EventoActual($IdJuego)
    {
        $resultado = DB::table('evento as e')
            ->join('juego as j', 'j.idJuego', 'e.idJuego')
            ->where('e.idJuego', $IdJuego)
            ->where('estadoEvento', 1)
            ->first();
        return $resultado;
    }

    public static function CambiarEstadoAnimacionEvento($IdEvento, $token_animacion)
    {

        $resultado = false;
        $respuesta = DB::table('evento')
            ->where('idEvento', $IdEvento)
            ->where('tokenAnimacion', $token_animacion)
            ->first();

        if ($respuesta != null) {
            try {
                $evento = Evento::findorfail($IdEvento);
                $evento->estadoAnimacion = 1;
                $evento->save();
                $resultado = true;
            } catch (QueryException $ex) {
            }
        }
        return $resultado;
    }

    public static function EventoTokenAnimacion(string $token_generado, $idEvento)
    {
        $evento = "";
        try {
            $evento = Evento::findorfail($idEvento);
            $evento->tokenAnimacion = $token_generado;
            $evento->save();
        } catch (QueryException $ex) {
        }

        return $evento;
    }

    public static function ValidarTokenAnimacion($idEvento)
    {
        $token = "";
        $evento = Evento::findorfail($idEvento);
        if ($evento->tokenAnimacion != "") {
            $token = $evento->tokenAnimacion;
        }
        return $token;
    }

    public static function ObtenerUltimoEvento($idJuego, $fechaIni, $fechaFin)
    {
        $resultado = DB::table('evento as e')
            ->where('e.idJuego', $idJuego)
            ->whereBetween('e.fechaEvento', array($fechaIni, $fechaFin))
            ->orderBy('idEvento', 'desc')
            ->first();
        return $resultado;
    }

    public static function GenerarEventoJobNuevo()
    {
        $Configuracion = DB::table('configuracion_generar_evento')->first();
        if ($Configuracion != null) {
            $fecha_inicio = today()->toDateString() . ' ' . $Configuracion->HoraInicioIntervalo;
            $fecha_fin = today()->toDateString() . ' ' . $Configuracion->HoraFinIntervalo;
        } else {
            $fecha_inicio = today()->startOfDay()->toDateTimeString();
            $fecha_fin = today()->endOfDay()->toDateTimeString();
        }
        $ListaJuego = Juego::JuegoListarLapsoJson();
        foreach ($ListaJuego as $juego) {
            //Evento creado anteriormente
            $evento_creado = Evento::ObtenerUltimoEvento($juego->idJuego, $fecha_inicio, $fecha_fin);
            if ($evento_creado != null) {
                $fechaIni = $evento_creado->fechaFinEvento;
                $fechaFin = "";
                while ($fechaIni < $fecha_fin) {
                    if ($juego->lapsoProxEventoHoras > 0) {
                        $NumeroHoras = $juego->lapsoProxEventoHoras;
                        $fechaFin = Carbon::parse($fechaIni)->addHours($NumeroHoras);
                    } else if ($juego->lapsoProxEventoMinutos > 0) {
                        $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                        $fechaFin = Carbon::parse($fechaIni)->addMinutes($NumeroMinutos);
                    }
                    if ($fechaIni > $fecha_fin) {
                        break;
                    } else {
                        $event = new Evento();
                        $posiciones = $event->generar_posiciones_random();
                        Evento::RegistrarEvento($juego, $fechaIni, $fechaFin->toDateTimeString(), $posiciones);
                        $fechaIni = $fechaFin->toDateTimeString();
                    }
                }
            } else {
                $fechaIni = $fecha_inicio;
                $fechaFin = "";
                while ($fechaIni < $fecha_fin) {
                    if ($juego->lapsoProxEventoHoras > 0) {
                        $NumeroHoras = $juego->lapsoProxEventoHoras;
                        $fechaFin = Carbon::parse($fechaIni)->addHours($NumeroHoras);
                    } else if ($juego->lapsoProxEventoMinutos > 0) {
                        $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                        $fechaFin = Carbon::parse($fechaIni)->addMinutes($NumeroMinutos);
                    }
                    if ($fechaIni >= $fecha_fin) {
                        break;
                    } else {
                        $event = new Evento();
                        $posiciones = $event->generar_posiciones_random();
                        Evento::RegistrarEvento($juego, $fechaIni, $fechaFin->toDateTimeString(), $posiciones);
                        $fechaIni = $fechaFin->toDateTimeString();
                    }
                }
            }
        }
    }

    public static function EventoEjecucionUnico()
    {
        $evento = DB::table('evento')
            ->where('estadoEvento', 1)
            ->first();
        return $evento;
    }

    public static function GenerarResultadoEvento_CambiarEstadoEvento()
    {
        $Configuracion = DB::table('configuracion_generar_evento')
            ->first();
        if ($Configuracion != null) {
            $fechaIni = today()->toDateString() . ' ' . $Configuracion->HoraInicioIntervalo;
            $fechaFin = today()->toDateString() . ' ' . $Configuracion->HoraFinIntervalo;
        } else {
            $fechaIni = today()->startOfDay()->toDateTimeString();
            $fechaFin = today()->endOfDay()->toDateTimeString();
        }
        $lista_Juegos = Juego::JuegoListarLapsoJson();
        foreach ($lista_Juegos as $juego) {
            $ListaEventosDia = DB::table('evento as e')
                ->whereBetween('e.fechaEvento', array($fechaIni, $fechaFin))
                ->where('e.idJuego', $juego->idJuego)
                ->get();
            foreach ($ListaEventosDia as $li) {
                if ($li->fechaEvento < now() && $li->fechaFinEvento > now()) {
                    $val = Evento::findorfail($li->idEvento);
                    if ($val->estadoEvento == 0) {
                        $val->estadoEvento = 1;
                        $val->save();
                    }
                } else if ($li->fechaEvento < now() && $li->fechaFinEvento < now() && $li->estadoEvento == 1) {
                    $evento = Evento::findorfail($li->idEvento);
                    $evento->estadoEvento = 2;
                    $evento->save();
                }
            }

        }
    }

    public static function CerrarEventoJuego($IdJuego)
    {
        $UltimoEvento = Evento::where('idJuego', $IdJuego)->first();
        $resultado = Evento::findorfail($UltimoEvento->idEvento);
        $resultado->estadoEvento = 2;
        $resultado->save();
    }

    public static function EventosDiaActualGenerados()
    {
        $Configuracion = DB::table('configuracion_generar_evento')->first();
        if ($Configuracion != null) {
            $fecha_inicio = today()->toDateString() . ' ' . $Configuracion->HoraInicioIntervalo;
            $fecha_fin = today()->toDateString() . ' ' . $Configuracion->HoraFinIntervalo;
        } else {
            $fecha_inicio = today()->startOfDay()->toDateTimeString();
            $fecha_fin = today()->endOfDay()->toDateTimeString();
        }

        $lista = DB::table('evento as e')
            ->whereBetween('e.fechaEvento', array($fecha_inicio, $fecha_fin))
            ->where('e.estadoEvento', 0)
            ->get();
        return $lista;
    }


    //////////////////////FUNCIONES GENERAR PUNTOS RANDOM
    public function random_posicion($min, $max)
    {
        $numero = (($this->random_0_1() * ($max - $min)) + $min);
        $numero_decimal = number_format((float)$numero, 2, '.', '');
        return $numero_decimal;
    }

    public function generar_posiciones_random()
    {
        $array_puntos = array();
        // rango z=> -2.5  a   2.5
        for($i=0;$i<40;$i++){
            $randomx = $this->random_0_1() >= 0.5 ? abs($this->random_posicion(0, 2.3)) : -abs($this->random_posicion(0, 2.3)) ;  
            $randomz = $this->random_0_1() >= 0.5 ? abs($this->random_posicion(0, 2.3)) : -abs($this->random_posicion(0, 2.3)); 
            $obj = (object) [
                'x' => $randomx,
                'y' => 0,
                'z' => $randomz
            ];
            array_push($array_puntos, $obj);

        }
        return $array_puntos;
    }

    function random_0_1()
    {
        return (float)rand() / (float)getrandmax();
    }
    /////FIN FUNCIONES GENERAR PUNTOS RANDOM

}
