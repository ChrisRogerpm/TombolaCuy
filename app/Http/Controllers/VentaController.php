<?php

namespace App\Http\Controllers;

use App\AperturaCaja;
use App\Evento;
use App\Ticket;
use App\Apuesta;

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
        return response()->json(['respuesta' => $respuesta, 'mensaje' => $mensaje_error,
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
            $tickets=Ticket::BuscarTicket($datos["idEvento"],$datos["idTicket"]);
            $respuesta = true;
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
               return response()->json([
            'tickets' => $tickets
            ]);
    }

    public function VentaDatosJson()
    {
            $usuarionombre="BTD OSCAR AGUILAR";
        $usuario = 1;
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
            //'jugador' => $jugador,
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
;
        try {
              $d = new DNS1D();//echo asset('public/img/barcodes/');                
         $d->setStorPath( asset('public/img/barcodes/'));
      $codigo_barrahtml= $d->getBarcodeHTML($Ticket_Imprimir["Nro_Evento"], "EAN13",1,11);
        $imagen_barrahtml=DNS1D::getBarcodePNG($Ticket_Imprimir["Nro_Evento"], "EAN13",3,33);
// $codigo_barra=DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1));
//echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T");


//     QRcode::png($formData, $codesDir.$codeFile, $_POST['ecc'], $_POST['size']);

// echo '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';

 // $codigo=base64_encode(QrCode::format('png')->merge('ss.png', 0.3, true)
 //                        ->size(500)->errorCorrection('H')
 //                         ->generate('Welcome to kerneldev.com!'));

 $png = QrCode::format('png')->size(512)->generate($Ticket_Imprimir["Nro_Evento"]);
$image_qrcode = base64_encode($png);

// QrCode::margin(50)->generate('My First QR code');
// $renderer = new ImageRenderer(
//     new RendererStyle(200),
//     new ImagickImageBackEnd()
// );
// $writer = new Writer($renderer);
// $qr_image = base64_encode($writer->writeString($string));
// $imagen_qrcode="<img src='data:image/png;base64, ".$codigo."'>";
        } catch (QueryException $ex) {
            $mensaje_error = $ex->errorInfo;
        }
        return response()->json([
                               'codigo_barrahtml'=> $codigo_barrahtml,
                               'codigo_barra_src'=>$imagen_barrahtml,
                               'qrcode_src'=> $image_qrcode,
                                  'mensaje' => "1"]);
    }

}
