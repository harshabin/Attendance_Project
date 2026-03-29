<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class Settings extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function home(Request $request){
	
	   // $pdo = DB::connection()->getPdo();

	return view("users.home");

}

public function accessebility(Request $request){
	
	 

	return view("settings.accessebility");

}
public function add(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("name");
	$user_name=$request->post("user_name");
	$mobile_number=$request->post("mobile_number");
	$pwd=$request->post("pwd");
	$address=$request->post("address");
    

	

	if($name==""||$user_name==""||$mobile_number==""||$pwd==""||$address==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		"user_name"=>$user_name,
		"mobile_number"=>$mobile_number,
		"pwd"=>$pwd,
		"address"=>$address,
		"role"=>"receptionist",
		
		"created_on"=>$created_on,
		



	);
	
	$input_data=json_encode($input_data);
	

	$data=$this->CallRaw('add_users',array($input_data));
	if($data[0][0]->is_unique==1){
		return response(json_encode(array("data"=>"User name already exists","status_code"=>500)));
	}

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}
public function get_users(Request $request){
	$start=$request->post("start");
	$length=$request->post("length");
	$search=($request->post("search"))['value'];
	
	 
	$data=$this->CallRaw('get_users',array($start,$length,$search));
	
//print_r($data);die();	

	echo json_encode(array(
"data"=>$data[1],
"recordsTotal"=>$data[0][0]->total,
"recordsFiltered"=>$data[0][0]->total
));


}

public function view(Request $request,$id){
	
	$data=DB::select('call get_registrations_id(?)',array($id));
	$registered_for=DB::select('call get_registration_for_id(?)',array($id));
	
	$checkup_data=DB::select('call fetch_checkup(?)',array("vaccination"));
	foreach ($checkup_data as $chk) {
		$chk->is_checked=0;
		foreach ($registered_for as $rchk) {
			if($chk->id==$rchk->id){
				$chk->is_checked=1;
				break;

			}
		}
		
	}
	
	//print_r($checkup_data);die();

	return view("registration.view",compact('data','checkup_data'));

}
public function sms_edit(Request $request){
	
	$data=$this->CallRaw('get_sms_details',array());
	$data=$data[0];

	

	return view("settings.sms_edit",compact('data'));

}

public function smtp_edit(Request $request){
	
	$data=$this->CallRaw('get_smtp_settings',array());
	$data=$data[0];
	

	return view("settings.smtp_edit",compact('data'));

}

public function sms_update(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$text=$request->post("text");
	$checkup_text=$request->post("checkup_text");
	$url=$request->post("url");
	
	$ids=$request->post("ids");
    

	

	if($text==""||$url==""||$checkup_text==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"text"=>$text,
		"url"=>$url,
		"ids"=>$ids,
		"checkup_text"=>$checkup_text,
		
		



	);
	
	$input_data=json_encode($input_data);
	

	$data=$this->CallRaw('sms_update',array($input_data));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public function smtp_update(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$host=$request->post("host");
	$port=$request->post("port");
	
	$ids=$request->post("ids");
	$password=$request->post("password");
	$user_name=$request->post("user_name");
    

	

	if($host==""||$port==""||$user_name==""||$password==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"host"=>$host,
		"port"=>$port,
		"ids"=>$ids,
		"password"=>$password,
		"user_name"=>$user_name,
		
		



	);
	
	$input_data=json_encode($input_data);
	

	$data=$this->CallRaw('smtp_update',array($input_data));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public  function CallRaw($procName, $parameters = null, $isExecute = false)
{
    $syntax = '';
    for ($i = 0; $i < count($parameters); $i++) {
        $syntax .= (!empty($syntax) ? ',' : '') . '?';
    }
    $syntax = 'CALL ' . $procName . '(' . $syntax . ');';

    $pdo = DB::connection()->getPdo();
    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
    $stmt = $pdo->prepare($syntax,[\PDO::ATTR_CURSOR=>\PDO::CURSOR_SCROLL]);
    for ($i = 0; $i < count($parameters); $i++) {
        $stmt->bindValue((1 + $i), $parameters[$i]);
    }
    $exec = $stmt->execute();
    if (!$exec) return $pdo->errorInfo();
    if ($isExecute) return $exec;

    $results = [];
    do {
        try {
            $results[] = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $ex) {

        }
    } while ($stmt->nextRowset());


    if (1 === count($results)) return $results[0];
    return $results;
}


public function get_all_users(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	$term=$request->get("q");
	$data=DB::select("call get_all_users(?)",array($term));
	//print_r($data);

	$result=array();

	foreach ($data as $dt) {
		$result[]=array(
			"label"=>$dt->name,
			"value"=>$dt->name,
			"id"=>$dt->user_name



		);

		}
		return response(json_encode($result));
	}

	public function get_user_accessibility(Request $request){
		session_start();
		$user_name=$request->post("user_name");
		$data=DB::select("call get_all_menus()");
		//print_r($data);
		$accessebility=DB::select("call get_user_for_menu(?)",array($user_name));
		$accessebility=json_decode($accessebility[0]->accessibility);
		//print_r($accessebility);
		foreach ($data as $dt) {
			//echo $dt->id;
			$dt->checked="";
			if(isset($accessebility)){

			

			foreach ($accessebility as $ac) {
				if($dt->menu==$ac->menu){
					$dt->checked="checked";



				}
			}
			}
		}
		
		return response(json_encode(array("data"=>$data,"status_code"=>200)));


	}

	public function user_accessibility_update(Request $request){
		session_start();
		$chk=$request->post("chk");
		$user_name=$request->post("user_name");
		$data=array();
		foreach ($chk as $c) {
			$data[]=array("menu"=>$c);
			
		}
		$data=json_encode($data);
		$data=DB::select("call user_accessibility_update(?,?)",array($data,$user_name));
		return response(json_encode(array("data"=>"Successful","status_code"=>200)));

	}
	public function run_cron(Request $request){
		\Artisan::call('schedule:run');
	}
}
