<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use DB;

class UpdateSMSStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update_sms_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To pull a list of running low of stock products, send notification to admin at 6 PM daily via email.';

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
     * @return int
     */
    public function handle()
    {
date_default_timezone_set("Asia/Kolkata");
    $now=date("Y-m-d H:i:s");
DB::select("call revert_sms_status_cron(?)",array($now));
 \Log::info("sms_status".$now);
        $this->info('Daily report has been sent successfully!');
        return 'Daily report has been sent successfully!';
    
}
  
}