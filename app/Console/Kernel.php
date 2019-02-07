<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\JobCommand1',
        'App\Console\Commands\JobCommand2',
        'App\Console\Commands\JobCommand3',
        'App\Console\Commands\JobCommand4',
        'App\Console\Commands\JobCommand5',
        'App\Console\Commands\JobCommand6',
        'App\Console\Commands\JobCommand7',
        'App\Console\Commands\JobCommand8',
        'App\Console\Commands\JobCommand9',
        'App\Console\Commands\JobCommand10',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('command:name1')->everyMinute();
         $schedule->command('command:name2')->everyMinute();
         $schedule->command('command:name3')->everyMinute();
         $schedule->command('command:name4')->everyMinute();
         $schedule->command('command:name5')->everyMinute();
         $schedule->command('command:name6')->everyMinute();
         $schedule->command('command:name7')->everyMinute();
         $schedule->command('command:name8')->everyMinute();
         $schedule->command('command:name9')->everyMinute();
         $schedule->command('command:name10')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
