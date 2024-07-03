<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\VerifyDiscounts::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Programar el comando para que se ejecute cada hora
        $schedule->command('discounts:verify')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
