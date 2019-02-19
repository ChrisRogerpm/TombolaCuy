<?php

namespace App\Http\Controllers;

use App\AperturaCaja;
use App\Evento;
use App\Ticket;
use App\Apuesta;
use App\GanadorEvento;
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
        return view('Venta.Index');
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
            $id_ticketinsertado=$data->idTicket;
            foreach($apuestas as $apu){
                $apu["idTicket"]=$id_ticketinsertado;
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
            $apuestas_ticket= Ticket::BuscarApuestasIdTicket($idticket);
            $tickets=Ticket::BuscarGanadoresTicket($idticket);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
               return response()->json([
                    'apuestas_ticket'=> $apuestas_ticket,
                    'ticketbuscado'=>$idticket,
                    'tickets' => $tickets
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
            foreach($apuestas as $apu){
            $apuestaobjeto=$request->merge($apu);

                $ganadorevento=GanadorEvento::GuardarGanadorEvento($apuestaobjeto);
            }
            Ticket::TicketPagarEstado($idTicket);
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

    public function HistorialDatosJson()
    {
        $mensaje_error = "";
        try {
            $historial = Evento::HistorialEvento();
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
            'historial' => $historial,
            'mensaje' => $mensaje_error]);
    }

    public function ImprimirDatosJson(Request $request){
        $mensaje_error = "";
        $Ticket_Imprimir= $request->input("TICKET_IMPRIMIR");
        try {
            $d = new DNS1D();//echo asset('public/img/barcodes/');                
            $d->setStorPath( asset('public/img/barcodes/'));
            $CODIGO=sprintf('%018d', $Ticket_Imprimir["Id_Ticket"]);
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
