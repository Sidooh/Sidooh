<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Nabcellent\Kyanda\Console\TransactionStatusCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
//        Commands\GenerateMpesaToken::class
//        Commands\QueryAirtimeStatus::class
//    TODO: Remove this once library is updated
        TransactionStatusCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->command('mpesa:generateToken')
//            ->cron('55 * * * *')->withoutOverlapping();

        $schedule->command('mpesa:query_status')
            ->everyFiveMinutes()
            ->withoutOverlapping(5)
            ->sendOutputTo('storage/logs/command.log')
//            ->emailOutputOnFailure('sidserviceske@gmail.com')
            ->runInBackground();

        $schedule->command('airtime:status')
//            ->everyMinute()
            ->withoutOverlapping()
            ->sendOutputTo('storage/logs/command.log')
//            ->emailOutputOnFailure('sidserviceske@gmail.com')
            ->runInBackground();

        $schedule->command('sidooh:invest')
            ->daily()
            ->withoutOverlapping()
            ->sendOutputTo('storage/logs/command.log')
            ->emailOutputOnFailure('sidserviceske@gmail.com')
//            ->emailOutputTo('sidserviceske@gmail.com')
            ->runInBackground();
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
