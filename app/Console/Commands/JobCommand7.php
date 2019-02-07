<?php

namespace App\Console\Commands;

use App\Evento;
use App\Juego;
use Carbon\Carbon;
use Illuminate\Console\Command;

class JobCommand7 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name7';

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
        sleep(5);
        Evento::GenerarEventoJob();
    }
}
