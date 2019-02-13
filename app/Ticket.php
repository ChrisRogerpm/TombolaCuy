<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class Ticket extends Model
{
    protected $table = 'Ticket';

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

        public static function BuscarTicket($idEvento,$idTicket)
    {
/////////////////BUSCAR APUESTAS  DEL IDTICKET   QUE ESTEN  RESULTADO EVENTO  CON $idEvento
        $listar = DB::select(DB::raw('select apu.idTipoApuesta  
from apuesta AS apu
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

  
}
