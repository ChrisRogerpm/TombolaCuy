<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Ticket extends Model
{
    protected $table = 'ticket';

    protected $primaryKey = 'idTicket';

    public $timestamps = false;

    public $fillable = ['idAperturaCaja', 'idEvento','codigoQR','nroTicketParticipante','ganador','estadoTicket','montoTotal'];


    public static function TicketListarJson()
    {
        $listar = Ticket::all();
        return $listar;
    }

    public static function GuardarTicket(Request $request)
    {
        $Ticket = new Ticket();
        $Ticket->idAperturaCaja = $request->input('idAperturaCaja');
        $Ticket->idEvento = $request->input('idEvento');
        $Ticket->codigoQR = $request->input('codigoQR');
        $Ticket->nroTicketParticipante = $request->input('nroTicketParticipante');
        $Ticket->ganador = $request->input('ganador');
        $Ticket->estadoTicket = $request->input('estadoTicket');
        $Ticket->montoTotal = $request->input('montoTotal');
        $Ticket->fechaRegistro =date('Y-m-d H:i:s');
        $Ticket->save();
        return $Ticket;
    }

    public static function TicketPagarEstado($idTicket)
    {
        $Ticket = Ticket::findorfail($idTicket);
        $Ticket->estadoTicket = 2;
        $Ticket->save();
        return $Ticket;
    }


    public static function BuscarGanadoresTicketidEvento($idEvento,$idTicket)
    {
/////////////////BUSCAR APUESTAS  DEL IDTICKET   QUE ESTEN  RESULTADO EVENTO  CON $idEvento
        $listar = DB::select(DB::raw('select apu.idTipoApuesta ,tipapu.valorapuesta as TipoApuestaValor,tipapu.nombre as TipoApuestaNombre,tipopago.nombre as TipoPagoNombre
            from apuesta AS apu
            left join tipo_apuesta tipapu on tipapu.idTipoApuesta=apu.idTipoApuesta
            left join tipo_pago tipopago on tipopago.idTipoPago=tipapu.idTipoPago
             where apu.idTicket=(select tick.idTicket from ticket tick where tick.idTicket='.$idTicket.')
             and  apu.idTipoApuesta 
            in 
            (
                SELECT idTipoApuesta FROM
                (
                    SELECT idTipoApuesta
                    FROM resultado_evento where idEvento='.$idEvento.'
                    GROUP BY idTipoApuesta
                    
                ) AS subquery
            )


            '));
        return $listar;
    }

        public static function BuscarGanadoresTicket($idTicket)
    {
/////////////////BUSCAR APUESTAS  DEL IDTICKET   QUE ESTEN  en RESULTADO EVENTO  CON idEvento del ticket
        $listar = DB::select(DB::raw('
                    select  tick.estadoTicket,apu.idApuesta,apu.idTicket,apu.idTipoApuesta ,tipapu.valorapuesta as TipoApuestaValor,resev.idResultadosEvento,
                    resev.multiplicadorApuestaGanada, apu.montoApostado,
                    tipapu.nombre as TipoApuestaNombre,
                    tipopago.nombre as TipoPagoNombre, tick.idEvento,ev.nombre as EventoNombre, ev.apuestaMaxima
                    from apuesta AS apu
                    left join ticket tick on tick.idTicket= apu.idTicket
                    left join evento ev on ev.idEvento = tick.idEvento
                    left join tipo_apuesta tipapu on tipapu.idTipoApuesta=apu.idTipoApuesta
                    left join tipo_pago tipopago on tipopago.idTipoPago=tipapu.idTipoPago 
                    left join resultado_evento resev on resev.idTipoApuesta= tipapu.idTipoApuesta

                     where apu.idTicket='.$idTicket.'  and resev.idEvento=tick.idEvento
                     and  apu.idTipoApuesta 
                    in 
                    (
                        SELECT idTipoApuesta FROM
                        (
                            SELECT idTipoApuesta
                            FROM resultado_evento /*where idEvento=1953*/
                            GROUP BY idTipoApuesta
                            
                        ) AS subquery
                    )

            '));
        return $listar;
    }


    public static function BuscarApuestasIdTicket($idTicket)
    {
/////////////////BUSCAR APUESTAS  DEL IDTICKET   QUE ESTEN  RESULTADO EVENTO  CON $idEvento
        $listar = DB::select(DB::raw("
                               
                                 select  tick.idEvento,tipoapuesta.idTipoApuesta, tipoapuesta.valorapuesta, tipopago.nombre from apuesta 
                                left join tipo_apuesta tipoapuesta on  tipoapuesta.idTipoApuesta=apuesta.idTipoApuesta 
                                left join tipo_pago tipopago on tipopago.idTipoPago = tipoapuesta.idTipoPago
                                left join ticket tick on tick.idTicket=apuesta.idTicket
                                where apuesta.idTicket='".$idTicket."'
                                "));
        return $listar;
    }


    public static function ResultadosEvento($idEvento)
    {
/////////////////BUSCAR APUESTAS  DEL IDTICKET   QUE ESTEN  RESULTADO EVENTO  CON $idEvento
        $listar = DB::select(DB::raw('
                                SELECT *
                            FROM resultado_evento where idEvento='.$idEvento.'
                            
                                '));
        return $listar;
    }

  
}
