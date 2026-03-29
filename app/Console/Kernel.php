<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
    /usr/local/bin/php /home/avmultihospital/public_html/admin/artisan schedule:run >> /dev/null 2>&1
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\SendSMS::class,
         Commands\SendSMSRoutine::class,
          Commands\SendSMSNonRoutine::class,
          Commands\UpdateSMSStatus::class
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->daily();
         // $schedule->command('inspire')->everyMinute();

          $schedule->command('daily:lowstock_report')->everyMinute();  
         
          $schedule->command('daily:routine')->everyMinute();  
          $schedule->command('daily:non_routine')->everyMinute();  
          $schedule->command('daily:update_sms_status')->daily();  

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
