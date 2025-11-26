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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('verificar:deudores')->weeklyOn('1', '15:30');
        $schedule->command('verificar:deudores')->weeklyOn('4', '15:30');
        //$schedule->command('verificar:deudores')->weeklyOn('5', '15:00');
        $schedule->command('test:cron')->weeklyOn('1', '13:35');
        $schedule->command('asistencia:verificar')->weekdays()->at('20:00');
        $schedule->command('verificar:asistencia-profesores')->weekdays()->at('23:00');
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
