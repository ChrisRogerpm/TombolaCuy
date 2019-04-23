<?php

namespace App\Console\Commands;

use App\Evento;
use App\Juego;
use Carbon\Carbon;
use Illuminate\Console\Command;

class JobCommand1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name1';

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
//        Evento::GenerarEventoJob();
        for ($i = 0; $i < 86400; $i++) {
            sleep(1);
            Evento::GenerarResultadoEvento_CambiarEstadoEvento();
        }
    }
}
