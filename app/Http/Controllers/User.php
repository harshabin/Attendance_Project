<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class User extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function home(Request $request){
	
	   // $pdo = DB::connection()->getPdo();

	return view("users.home");

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
public function edit(Request $request,$id){
	
	$data=$this->CallRaw('get_users_id',array($id));
	$data=$data[0];
	

	return view("users.edit",compact('data'));

}



public function update(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("name");
	$user_name=$request->post("user_name");
	$mobile_number=$request->post("mobile_number");
	$pwd=$request->post("pwd");
	$address=$request->post("address");
	$ids=$request->post("ids");
    

	

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
		"ids"=>$ids,
		
		"created_on"=>$created_on,
		



	);
	
	$input_data=json_encode($input_data);
	

	$data=$this->CallRaw('update_users',array($input_data));
	//print_r($data);
	if($data[0][0]->is_unique==1){
		return response(json_encode(array("data"=>"User name already exists","status_code"=>500)));
	}
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public function disable(Request $request,$id,$status){

	if($status=="active"){
		$stat="disabled";

	}else{
		$stat="active";
	}


	$data=DB::select('call disable_users(?,?)',array($id,$stat));
	

	
	     return \Redirect::route("users.home");





}

public function delete(Request $request,$id){

	


	$data=DB::select('call delete_users(?)',array($id));
	

	
	return \Redirect::route("users.home");




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
}
