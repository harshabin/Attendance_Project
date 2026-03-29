<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class MasterInfantVaccination extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function home(Request $request){
	

	//$data=DB::select('call fetch_checkup("vaccination")');

	
	return view("master_infant_vaccination.home");

}

// public function checkup(Request $request){

// return view("registration.checkup");

	

// }

public function add(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("vaccination");
	$dob=$request->post("child-birth");
	$alerts=$request->post("send-alerts");
	
	$remarks=$request->post("remarks");

	

	if($name==""||$dob==""||$alerts==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	if(!is_numeric($dob)||!is_numeric($alerts)){
		return response(json_encode(array("data"=>"Days should be numeric","status_code"=>500)));
	}
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		"days_from_child_birth"=>$dob,
		"send_alerts_before"=>$alerts,
		"notification_cycle"=>0,
		"first_alert"=>0,
		"second_alert"=>0,
		"third_alert"=>0,
		
		"remarks"=>$remarks,
		"type"=>"vaccination",
		"created_on"=>$created_on,
		"created_by"=>$user



	);
	
	$input_data=json_encode($input_data);
	$routine_checkup=array();
	$count=DB::select('call check_for_unique_checkup(?,?)',array($input_data,"{}"));
	//print_r($count);
	if(isset($count[0]->count) && $count[0]->count>=1){
return response(json_encode(array("data"=>"Vaccination already exists","status_code"=>500)));
	}
	

	$data=DB::select('call add_checkup(?,?)',array($input_data,"{}"));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}
public function get_master(Request $request){
	$start=$request->post("start");
	$length=$request->post("length");
	$search=($request->post("search"))['value'];
	
	$type="vaccination";
	$data=DB::select('call get_master_vaccination(?,?,?,?)',array($start,$length,$search,$type));
	$total=DB::select('call get_master_vaccination_total(?,?)',array($type,$search));


	echo json_encode(array(
"data"=>$data,
"recordsTotal"=>$total[0]->total,
"recordsFiltered"=>$total[0]->total
));


}

public function view(Request $request,$id){
	
	$data=DB::select('call get_master_vaccination_id(?)',array($id));
	// $registered_for=DB::select('call get_registration_for_id(?)',array($id));
	
	// $checkup_data=DB::select('call fetch_checkup_other(?)',array("vaccination"));
	// foreach ($checkup_data as $chk) {
	// 	$chk->is_checked=0;
	// 	foreach ($registered_for as $rchk) {
	// 		if($chk->id==$rchk->id){
	// 			$chk->is_checked=1;
	// 			break;

	// 		}
	// 	}
		
	// }
	
	//print_r($checkup_data);die();

	return view("master_infant_vaccination.view",compact('data'));

}
public function edit(Request $request,$id){
	
	$data=DB::select('call get_master_vaccination_id(?)',array($id));
	return view("master_infant_vaccination.edit",compact('data'));

}



public function update(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("vaccination");
	$dob=$request->post("child-birth");
	$alerts=$request->post("send-alerts");
	
	$remarks=$request->post("remarks");
	$ids=$request->post("ids");

	

	if($name==""||$dob==""||$alerts==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	if(!is_numeric($dob)||!is_numeric($alerts)){
		return response(json_encode(array("data"=>"Days should be numeric","status_code"=>500)));
	}

	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		"days_from_child_birth"=>$dob,
		"send_alerts_before"=>$alerts,
		
		"remarks"=>$remarks,
		"type"=>"vaccination",
		"created_on"=>$created_on,
		"created_by"=>$user,
		"ids"=>$ids



	);
	
	$input_data=json_encode($input_data);
	
	$routine_checkup=array();
	
$count=DB::select('call check_for_unique_checkup_id(?)',array($input_data));
	
	if(isset($count[0]->count) && $count[0]->count>=1){
return response(json_encode(array("data"=>"Vaccination already exists","status_code"=>500)));
	}
	
	$data=DB::select('call update_checkup(?,?)',array($input_data,"{}"));
	if($data[0]->success==1){
		return response(json_encode(array("data"=>"Successful","status_code"=>200)));
	}else{
		return response(json_encode(array("data"=>"Something went wrong","status_code"=>500)));
	}
	

	
	

}

public function disable(Request $request,$id,$status){

	if($status=="active"){
		$stat="disabled";

	}else{
		$stat="active";
	}


	$data=DB::select('call disable_checkup(?,?)',array($id,$stat));
	

	
	     return \Redirect::route("master_infant_vaccination.home");





}

public function delete(Request $request,$id){

	


	$data=DB::select('call delete_checkup(?)',array($id));
	//print_r($data[0]->count);die();
	

	return redirect()->route('master_infant_vaccination.home', ['param' => $data[0]->count]);

	//return \Redirect::route("master_infant_vaccination.home");




}
}
