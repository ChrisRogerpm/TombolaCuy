<?php

namespace App\Http\Controllers;

use App\AperturaCaja;
use App\Evento;
use App\Ticket;
use App\Apuesta;
use App\GanadorEvento;
use App\Ubigeo;
use App\ConfiguracionGeneral;
use Auth;
use \Milon\Barcode\DNS1D;

 use BaconQrCode\Renderer\ImageRenderer;
 use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
 use BaconQrCode\Renderer\RendererStyle\RendererStyle;
 use BaconQrCode\Writer;
 use SimpleSoftwareIO\QrCode\Facades\QrCode;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;

class VentaController extends Controller
{


        public function Index()
    {
        $usuarionombre=Auth::user()->usuario;//"BTD OSCAR AGUILAR";
        $usuario = Auth::user()->idUsuario;
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
            $tipoapuesta = Evento::TipoApuestaListar();

            $divzero=null;
            $primerafila=array();
            $segundafila=array();
            $tercerafila=array();
            $cuartafila=array();
            $quintafila=array();
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [100])){
                        $divzero=$apuesta;
                }
            }
            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [3,6,9,12,15,18,21,24])){
                        array_push($primerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [2,5,8,11,14,17,20,23])){
                        array_push($segundafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [1,4,7,10,13,16,19,22])){
                        array_push($tercerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [103,104,105,106])){
                        array_push($cuartafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [107,101,25,26,102,108])){
                        array_push($quintafila, $apuesta);
                }
            }
        
            if(count($aperturacajadatos)>0){
                $aperturacajadatos=$aperturacajadatos[0];
            }
            $eventos = Evento::EventoListar();
            $dinerodefault = Evento::DineroDefaultListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        };
        return view('Venta.Index', compact("usuario","hora_servidor","aperturacajadatos","eventos","dinerodefault","tipoapuesta",
            "divzero","primerafila","segundafila","tercerafila","cuartafila","quintafila"));
    }


    public function IndexNuevo()
    {
        $usuarionombre=Auth::user()->usuario;//"BTD OSCAR AGUILAR";
        $usuario = Auth::user()->idUsuario;
        $error="";
        try {
            $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
            if(count($aperturacajadatos)==0){
                $error="No hay Apertura de Cajas";
             //   return view('Venta.IndexNuevo', compact("error"));
            }
            $tipoapuesta = Evento::TipoApuestaListar();
            if(count($tipoapuesta)==0){
                $error="No hay Apuestas";
                return view('Venta.IndexNuevo', compact("error"));
            }
            $divzero=null;
            $primerafila=array();
            $segundafila=array();
            $tercerafila=array();
            $cuartafila=array();
            $quintafila=array();
            $sextafila=array();
            $coloresfila=array();
            $rangosfila=array();
            $par_imparfila=array();
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [39])){
                        $divzero=$apuesta;
                }
            }
            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [1,2,3,4,5,6])){
                        array_push($primerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [7,8,9,10,11,12])){
                        array_push($segundafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [13,14,15,16,17,18])){
                        array_push($tercerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [19,20,21,22,23,24])){
                        array_push($cuartafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [25,26,27,28,29,30])){
                        array_push($quintafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [31,32,33,34,35,36])){
                        array_push($sextafila, $apuesta);
                }
            }

            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [37,38,39])){
                        array_push($coloresfila, $apuesta);
                }
            }

            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [40,41,42,45,46,47,48])){
                        array_push($rangosfila, $apuesta);
                }
            }
            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [43,44])){
                        array_push($par_imparfila, $apuesta);
                }
            }
            if(count($aperturacajadatos)>0){
                $aperturacajadatos=$aperturacajadatos[0];
            }
            $eventos = Evento::EventoListar();

            if($aperturacajadatos==null){
                $eventosdatos=null;
            }else{
                $eventosdatos = Evento::EventoDatosListar($aperturacajadatos->idPuntoVenta);

            }
            // if(count($eventodatos)==0){
            //     $eventosdatos=null;
            // }
              if(count($eventos)==0){
                $error="No hay Eventos Registrados";
               // return view('Venta.IndexNuevo', compact("error"));
            }
            $dinerodefault = Evento::DineroDefaultListar();
               if(count($dinerodefault)==0){
                $error="No hay Eventos DineroDefault";
                return view('Venta.IndexNuevo', compact("error"));
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        };
        $hora_servidor = date('Y-m-d H:i:s');
        return  view('Venta.IndexNuevo', compact("usuario","hora_servidor","aperturacajadatos","eventos","dinerodefault","tipoapuesta",
            "divzero","primerafila","segundafila","tercerafila","cuartafila","quintafila","sextafila","coloresfila",
            "rangosfila","par_imparfila","error","eventos","eventosdatos"));
    }


      public function CajaTablaFk()
    {
        $usuarionombre=Auth::user()->usuario;//"BTD OSCAR AGUILAR";
        $usuario = Auth::user()->idUsuario;
        $error="";
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
            if(count($aperturacajadatos)==0){
                $error="No hay Apertura de Cajas";
                return view('Venta.IndexNuevo', compact("error"));
            }
            $tipoapuesta = Evento::TipoApuestaListar();
            if(count($tipoapuesta)==0){
                $error="No hay Apuestas";
                return view('Venta.IndexNuevo', compact("error"));
            }
            $divzero=null;
            $primerafila=array();
            $segundafila=array();
            $tercerafila=array();
            $cuartafila=array();
            $quintafila=array();
            $sextafila=array();
            $coloresfila=array();
            $rangosfila=array();
            $par_imparfila=array();
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [39])){
                        $divzero=$apuesta;
                }
            }
            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [1,2,3,4,5,6])){
                        array_push($primerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [7,8,9,10,11,12])){
                        array_push($segundafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [13,14,15,16,17,18])){
                        array_push($tercerafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [19,20,21,22,23,24])){
                        array_push($cuartafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [25,26,27,28,29,30])){
                        array_push($quintafila, $apuesta);
                }
            }
             foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [31,32,33,34,35,36])){
                        array_push($sextafila, $apuesta);
                }
            }

            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [37,38,39])){
                        array_push($coloresfila, $apuesta);
                }
            }

            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [40,41,42,45,46,47,48])){
                        array_push($rangosfila, $apuesta);
                }
            }
            foreach($tipoapuesta as $apuesta) {
                if(in_array( $apuesta->idTipoApuesta, [43,44])){
                        array_push($par_imparfila, $apuesta);
                }
            }
            if(count($aperturacajadatos)>0){
                $aperturacajadatos=$aperturacajadatos[0];
            }
            $eventos = Evento::EventoListar();
              if(count($eventos)==0){
                $error="No hay Eventos Registrados";
               // return view('Venta.IndexNuevo', compact("error"));
            }
            $dinerodefault = Evento::DineroDefaultListar();
               if(count($dinerodefault)==0){
                $error="No hay Eventos DineroDefault";
                return view('Venta.IndexNuevo', compact("error"));
            }
            $eventosdatos = Evento::EventoDatosListar($aperturacajadatos->idPuntoVenta);
              if(count($eventos)==0){
                $error="No hay Eventos Registrados";
               // return view('Venta.IndexNuevo', compact("error"));
            }
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        };
$view=view('Venta.CajaTabla', compact("usuario","hora_servidor","aperturacajadatos","eventos","eventosdatos","dinerodefault","tipoapuesta",
            "divzero","primerafila","segundafila","tercerafila","cuartafila","quintafila","sextafila","coloresfila",
            "rangosfila","par_imparfila","error"))->render();
    return response()->json(['html'=>$view,'error'=>$error]);
        // return view('Venta.CajaTabla', compact("usuario","hora_servidor","aperturacajadatos","eventos","dinerodefault","tipoapuesta",
        //     "divzero","primerafila","segundafila","tercerafila","cuartafila","quintafila","sextafila","coloresfila",
        //     "rangosfila","par_imparfila","error"));
    }


    public function IndexAnterior()
    {
        $usuarionombre=Auth::user()->usuario;//"BTD OSCAR AGUILAR";
        $usuario = Auth::user()->idUsuario;
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
            if(count($aperturacajadatos)>0){
                $aperturacajadatos=$aperturacajadatos[0];
            }
            $eventos = Evento::EventoListar();
            $dinerodefault = Evento::DineroDefaultListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        };
        return view('Venta.IndexAnte', compact("usuario","hora_servidor","aperturacajadatos","eventos","dinerodefault"));
    }


    public function GuardarTicket(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try 
        {
            $datos=$request->datos;
            $ticketobjeto=$datos["TicketObjeto"];
            $apuestas=$datos["Apuestas"];
            $ticketobjeto=$request->merge($ticketobjeto);
            $data=Ticket::GuardarTicket($ticketobjeto);
            
            $idZonaComercial = Ubigeo::ObtenerZonaComercial($datos["idUbigeo"]);

            $id_ticketinsertado=$data->idTicket;
            foreach($apuestas as $apu){
                $apu["idTicket"]=$id_ticketinsertado;
                $apu["ZonaComercial"]=$idZonaComercial;
                Apuesta::GuardarApuestas($apu);
            }
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json(['respuesta' => $respuesta,
                                 'mensaje' => $mensaje_error,
                                 'id_ticketinsertado' => $data,
                                 'apuestas'=> $apuestas
                                ]);
    }


    public function BuscarTicket(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try 
        {
            $datos=$request->datos;
            $idticket = ltrim($datos["idTicket"], '0');
            $conf_general=ConfiguracionGeneral::ObtenerConfiguracionEvento();
           // $idEvento = $datos["idEvento"];
            $apuestas_ticket= Ticket::BuscarApuestasIdTicket($idticket);  ////Apuestas
            if(count($apuestas_ticket)>0){
                $idEvento=$apuestas_ticket[0]->idEvento;
                $resultados_evento=Ticket::ResultadosEvento($idEvento);
                $tickets=Ticket::BuscarGanadoresTicket($idticket);
                //$tickets=Ticket::BuscarGanadoresTicketidEvento($idEvento,$idticket);
            }else{
                $resultados_evento=null;
                $tickets=array();
            }

            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
               return response()->json([
                    // 'ticketnoexiste'=>$ticketnoexiste,
                    'apuestas_ticket'=> $apuestas_ticket, ////apuestas del ticket
                    'resultados_evento'=>$resultados_evento,
                    'ticketbuscado'=>$idticket,
                    'tickets' => $tickets  ,
                    'conf_general'=>$conf_general ////apuestas ganadoras 
                    ]);
    }

////guardar en ganador_evento y  cambia col estado de ticket a 2
  public function GuardarGanadorEvento(Request $request)
    {
        $respuesta = false;
        $mensaje_error = "";
        try 
        {
            $apuestas=$request->apuestas;
            $idTicket=$request->idTicket;
            $idAperturaCaja=$request->idAperturaCaja;
            foreach($apuestas as $apu){
                $apuestaobjeto=$request->merge($apu);
                $ganadorevento=GanadorEvento::GuardarGanadorEvento($apuestaobjeto);
            }
            Ticket::TicketPagarEstado($idTicket,$idAperturaCaja);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
               return response()->json([
                    'respuesta' => $respuesta
                    ]);
    }

    public function VentaDatosJson()
    {
        $usuarionombre=Auth::user()->usuario;//"BTD OSCAR AGUILAR";
        $usuario = Auth::user()->idUsuario;
        $lista = "";
        $mensaje_error = "";
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $aperturacajadatos = AperturaCaja::AperturaCajaListarActiva($usuario);
            $eventos = Evento::EventoListar();
            $dinerodefault = Evento::DineroDefaultListar();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'usuario'=>$usuarionombre,
            'hora_servidor' => $hora_servidor,
            'aperturacajadatos' => $aperturacajadatos,
            'eventos' => $eventos,
            'dinerodefault' => $dinerodefault,
            'mensaje' => $mensaje_error]);
    }

    public function EventoDatosJson(Request $request)
    {
        $mensaje_error = "";
        $idEvento = $request->input("idEvento");
        $idPuntoVenta = $request->input("idPuntoVenta");
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $jugador = Evento::CantidadGanadorEventoListar($idEvento)[0];
            $divisa = Evento::SimboloEvento($idEvento)[0];
            $jackpots = Evento::JackPotEvento($idPuntoVenta);
            $jackpotsuma = Evento::JackPotSumaEvento($idPuntoVenta)[0];
            $eventodatos = Evento::EventoId($idEvento)[0];

            $tipoapuesta = Evento::TipoApuestaListar();
            $dinerodefault = Evento::DineroDefaultListar();


            

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'eventodatos' => $eventodatos,
            'hora_servidor' => $hora_servidor,
            'jugador' => $jugador->cantidadganadores,
            'divisa' => $divisa->simbolo,
            'jackpots' => $jackpots,
            'jackpotsuma' => $jackpotsuma->sumajackpots,
            'tipoapuesta' => $tipoapuesta,
            'dinerodefault' => $dinerodefault,
            'mensaje' => $mensaje_error]);

    }

    public function JackpotDatosJson(Request $request)
    {
        $mensaje_error = "";
        $idPuntoVenta = $request->input("idPuntoVenta");
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $jackpots = Evento::JackPotEvento($idPuntoVenta);
            $jackpotsuma = Evento::JackPotSumaEvento($idPuntoVenta)[0];

        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'hora_servidor' => $hora_servidor,
            'jackpots' => $jackpots,
            'jackpotsuma' => $jackpotsuma->sumajackpots,
            'mensaje' => $mensaje_error]);
    }
    public function HistorialJackpotDatosJson(Request $request)
    {
        $mensaje_error = "";
        $idEvento = $request->input("idEvento");
        $idPuntoVenta = $request->input("idPuntoVenta");
        try {
            $hora_servidor = date('Y-m-d H:i:s');
            $jackpots = Evento::JackPotEvento($idPuntoVenta);
            $jackpotsuma = Evento::JackPotSumaEvento($idPuntoVenta)[0];
            $historial = Evento::HistorialEvento($idEvento);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'hora_servidor' => $hora_servidor,
            'jackpots' => $jackpots,
            'jackpotsuma' => $jackpotsuma->sumajackpots,
            'historial' => $historial,
            'mensaje' => $mensaje_error]);
    }
    public function HistorialDatosJson(Request $request)
    {
        $mensaje_error = "";
        $idEvento = $request->input("idEvento");

        try {
            $historial = Evento::HistorialEvento($idEvento);
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'historial' => $historial,
            'mensaje' => $mensaje_error]);
    }

        public function JugadoresDatosJson(Request $request)
    {
        $mensaje_error = "";
        $idEvento = $request->input("idEvento");

        try {
            $jugador = Evento::CantidadGanadorEventoListar($idEvento)[0];
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'jugador' => $jugador,
            'mensaje' => $mensaje_error]);
    }

    public function ImprimirDatosJson(Request $request){
        $mensaje_error = "";
        $Ticket_Imprimir= $request->input("TICKET_IMPRIMIR");
        try {
            $d = new DNS1D();//echo asset('public/img/barcodes/');                
            $d->setStorPath( asset('public/img/barcodes/'));
            $CODIGO=sprintf('%015d', $Ticket_Imprimir["Id_Ticket"]);
            $imagen_barrahtml=DNS1D::getBarcodePNG($CODIGO, "C128",2,80);
            $png = QrCode::format('png')->size(512)->generate($CODIGO);
            $image_qrcode = base64_encode($png);

        } catch (QueryException $ex) {
        $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                           // 'codigo_barrahtml'=> $codigo_barrahtml,
                           'codigo_barra_src'=>$imagen_barrahtml,
                           'qrcode_src'=> $image_qrcode,
                              'mensaje' => "1"]);
    }

}
