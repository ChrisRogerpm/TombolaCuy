<?php

namespace App\Console\Commands;

use App\Evento;
use App\Juego;
use Carbon\Carbon;
use Illuminate\Console\Command;

class JobCommand8 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name8';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ListaJuego = Juego::JuegoListarLapsoJson();
        foreach ($ListaJuego as $juego) {
            $JuegoEvento = Juego::JuegoEventoEjecucion($juego->idJuego);
            if ($JuegoEvento != null) {
                if (now() >= $JuegoEvento->fechaEvento) {
                    $respuesta = Juego::ActualizarEventoEjecucion($JuegoEvento->idEvento);
                    if ($respuesta) {
                        if ($juego->lapsoProxEventoHoras > 0) {
                            $NumeroHoras = $juego->lapsoProxEventoHoras;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addHours($NumeroHoras);
                            Evento::RegistrarEvento($juego,$fecha);
                        } else if ($juego->lapsoProxEventoDia > 0) {
                            $NumeroDias = $juego->lapsoProxEventoDia;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addDays($NumeroDias);
                            Evento::RegistrarEvento($juego,$fecha);
                        } else if ($juego->lapsoProxEventoDiaSemana > 0) {

                        } else if ($juego->lapsoProxEventoMinutos > 0) {
                            $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                            $fecha = Carbon::parse($JuegoEvento->fechaEvento)->addMinutes($NumeroMinutos);
                            Evento::RegistrarEvento($juego,$fecha);
                        }
                    }
                }
            } else {
                //crear evento desde 0
                if ($juego->lapsoProxEventoHoras > 0) {
                    $NumeroHoras = $juego->lapsoProxEventoHoras;
                    $fecha = now()->addHours($NumeroHoras);
                    Evento::RegistrarEvento($juego,$fecha);
                } else if ($juego->lapsoProxEventoDia > 0) {
                    $NumeroDias = $juego->lapsoProxEventoDia;
                    $fecha = now()->addDays($NumeroDias);
                    Evento::RegistrarEvento($juego,$fecha);
                } else if ($juego->lapsoProxEventoDiaSemana > 0) {

                } else if ($juego->lapsoProxEventoMinutos > 0) {
                    $NumeroMinutos = $juego->lapsoProxEventoMinutos;
                    $fecha = now()->addMinutes($NumeroMinutos);
                    Evento::RegistrarEvento($juego,$fecha);
                }
            }
        }
    }
}
