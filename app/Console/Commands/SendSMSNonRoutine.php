<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use DB;

class SendSMSNonRoutine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:non_routine';

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
       $registration=DB::select('call get_registration_cron()',array());
$mobile="";
$name="";
$created_on="";
$text="";
$url="";
 \Log::info("jagadish_non_routine11");
date_default_timezone_set("Asia/Kolkata");
    $now=date("Y-m-d");
    if(is_array($registration)){
       \Log::info(($registration));
foreach ($registration as $res) {
  
  if($res->sms_status=="active"){
     \Log::info($res->sms_status);
$mobile=$res->mobile_number;
$name=$res->name;
  $checkup=DB::select("call get_checkup_non_routine_cron($res->id)");
  

$days=0;
$send_on="";
if(is_array($checkup)){
foreach ($checkup as $chkp) {
\Log::info($res->id);
\Log::info($chkp->id);
  $checkups_history=DB::select("call get_checkups_history_cron(?,?)",array($res->id,$chkp->parent_id));
  if(is_array($checkups_history) && count($checkups_history)>0){

  if($chkp->type=="non_routine"){
    $first_alert_days=$chkp->check_up_days-$chkp->first_alert;
    $second_alert_days=$chkp->check_up_days-$chkp->second_alert;
    $third_alert_days=$chkp->check_up_days-$chkp->third_alert;
     $dt=$checkups_history[0]->checkup_date;
     \Log::info("checkupdate");
     \Log::info($dt);
    
     $due_checkup=date('Y-m-d', strtotime($dt. "+ $chkp->check_up_days days"));
     $due_checkup = date("D, d M Y", strtotime($due_checkup));

       $send_on=date('Y-m-d', strtotime($dt. "+ $first_alert_days days"));
       $send_on=explode(" ",$send_on);
      if($now==$send_on[0]){
           $this->send_sms($mobile,$name,$chkp->name,$due_checkup);
           DB::select("call update_sms_status_cron(?)",array($res->id));
        }
    $send_on=date('Y-m-d', strtotime($dt. "+ $second_alert_days days"));
      if($now==$send_on[0]){
           $this->send_sms($mobile,$name,$chkp->name,$due_checkup);
           DB::select("call update_sms_status_cron(?)",array($res->id));
       
}
$send_on=date('Y-m-d', strtotime($dt. "+ $third_alert_days days"));
      if($now==$send_on[0]){
          $this->send_sms($mobile,$name,$chkp->name,$due_checkup);
          DB::select("call update_sms_status_cron(?)",array($res->id));
       
}

  


  }



}
}
  }

}

}

        $this->info('Daily report has been sent successfully!');
        return 'Daily report has been sent successfully!';
      
    }
}
      public  function send_sms($mobile,$name,$checkup,$due_checkup){
$data=DB::select("call get_sms_details()");

    $url=$data[0]->url;
    $text=$data[0]->checkup_text;
    $find="{#var#}";
    $result = preg_replace("/$find/",$name,$text,1);
    $result = preg_replace("/$find/",$checkup,$result,1);
     $result = preg_replace("/$find/",$due_checkup,$result,1);
    $result = preg_replace("/$find/","9243155666, 9945271291",$result,1);
    $result=urlencode($result);
    $url= str_replace("{#number}",$mobile,$url);
    $url= str_replace("{#message}",$result,$url);
    $url= str_replace("DLT_Templateid","1207165899318542787",$url);
    $curl_handle=curl_init();
    \Log::info($result);
     \Log::info($url);
  curl_setopt($curl_handle,CURLOPT_URL,$url);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  curl_close($curl_handle);
  if (empty($buffer)){
      print "Nothing returned from url.<p>";
  }
  else{
      print $buffer;
  }


}
}