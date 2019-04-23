<?php

namespace App\Console\Commands;

use App\Evento;
use App\TipoApuesta;
use Illuminate\Console\Command;

class JobCommand3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name3';

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
        $eventos = Evento::all();
        $lista = [];
        foreach ($eventos as $e) {
            $numero_random = rand(0, 36);
            $lista [] = [
                'idEvento' => $e->idEvento,
                'random' => $numero_random];
        }
        foreach ($lista as $l) {
            TipoApuesta::TipoApuestaColor($l->random, $l->idEvento);
        }
    }
}
