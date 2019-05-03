<?php

namespace App\Console\Commands;

use App\Evento;
use App\Juego;
use Exception;
use Carbon\Carbon;
use Illuminate\Console\Command;

class JobCommand_ActivarEventos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ActivarEventos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activa Eventos, general evento mysql para cerrar evento ';

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
//        Evento::GenerarEventoJob();
       for ($i = 0; $i < 95555; $i++) {
            echo "-";
            $startTime = microtime(true);  
            try
            {
                Evento::ActivarEventos();
            }
            catch(Exception $ex){
                echo " ---------ERROR\n".$ex->getMessage();
            }
            echo $i." Tiempo : ". (microtime(true) - $startTime) ." segundos\n";
            //usleep( 10*1000 );
             Sleep(1);

        }
    }
}
