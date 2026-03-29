<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class MasterRoutineNonRoutine extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function home(Request $request){
	

	//$data=DB::select('call fetch_checkup("vaccination")');

	
	return view("master_routine_non_routine.home");

}

// public function checkup(Request $request){

// return view("registration.checkup");

	

// }

public function add(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("checkup");
	$type=$request->post("type");

	
	$remarks=$request->post("remarks");
	$notification=$request->post("notification");
	$alert1=$request->post("send-alerts1");
	$alert2=$request->post("send-alerts2");
	$alert3=$request->post("send-alerts3");
	$non_routine=array();
	$input_data=array();
	if($type=="routine"){

		if($name==""||$notification==""||$alert1==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));
		//$notification=0;

	}

if($notification<($alert1+$alert2+$alert3)){

return response(json_encode(array("data"=>"Alerts should not be greater than Notification days","status_code"=>500)));
}

	}else{

	

	if($name==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
$days=$request->post("days");
$alerts1=$request->post("alerts1");
$alerts2=$request->post("alerts2");
$alerts3=$request->post("alerts3");
$i=0;
$flag=0;
foreach ($days as $d) {

	if($d<($alerts1[$i]+$alerts2[$i]+$alerts3[$i])){
		$flag=1;
break;

}
$res=array(
"check_up_days"=>$d,
"first_alert"=>$alerts1[$i],
"second_alert"=>$alerts2[$i],
"third_alert"=>$alerts3[$i]


);

array_push($non_routine,$res);
$i++;	
}

if($flag==1){
	return response(json_encode(array("data"=>"Alerts should not be greater than Notification days","status_code"=>500)));
}


}
	
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		
		"notification_cycle"=>$notification,
		"first_alert"=>$alert1,
"second_alert"=>$alert2,
"third_alert"=>$alert3,
		
		"remarks"=>$remarks,
		"type"=>$type,
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
	

	$data=DB::select('call add_checkup(?,?)',array($input_data,json_encode($non_routine)));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}
public function get_master(Request $request){
	$start=$request->post("start");
	$length=$request->post("length");
	$search=($request->post("search"))['value'];
	
	$type="routine";
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
	
	$checkup_data=DB::select('call fetch_routine_non_routine(?)',array($id));
	// if(isset($checkup_data)){
	// 	$checkup_data=$checkup_data[0];

	// }
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

	return view("master_routine_non_routine.view",compact('data','checkup_data'));

}
public function edit(Request $request,$id){
	
	$data=DB::select('call get_master_vaccination_id(?)',array($id));
	// $registered_for=DB::select('call get_registration_for_id(?)',array($id));
	
	$checkup_data=DB::select('call fetch_routine_non_routine(?)',array($id));
	

	return view("master_routine_non_routine.edit",compact('data','checkup_data'));

}



public function update(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("checkup");
	$type=$request->post("type");

	
	$remarks=$request->post("remarks");
	$notification=$request->post("notification");
	$alert1=$request->post("send-alerts1");
	$alert2=$request->post("send-alerts2");
	$alert3=$request->post("send-alerts3");
	$ids=$request->post("ids");
	$non_routine=array();
	$input_data=array();
	if($type=="routine"){

		if($name==""||$notification==""||$alert1==""){
		return response(json_encode(array("data"=>"All1 * fields are required","status_code"=>500)));

	}
	if($notification<($alert1+$alert2+$alert3)){

return response(json_encode(array("data"=>"Alerts should not be greater than Notification days","status_code"=>500)));
}
if(($alert2!="")||($alert3!="")){
		//return response(json_encode(array("data"=>"Days should be numeric","status_code"=>500)));

	if(!is_numeric($alert1)||!is_numeric($alert2)||!is_numeric($alert3)){
		return response(json_encode(array("data"=>"Days should be numeric","status_code"=>500)));

	}
}
	}else{

	

	if($name==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
$days=$request->post("days");
$alerts1=$request->post("alerts1");
$alerts2=$request->post("alerts2");
$alerts3=$request->post("alerts3");
$i=0;
$flag=0;
foreach ($days as $d) {
	if($d<($alerts1[$i]+$alerts2[$i]+$alerts3[$i])){
		$flag=1;
break;

}
$res=array(
"check_up_days"=>$d,
"first_alert"=>$alerts1[$i],
"second_alert"=>$alerts2[$i],
"third_alert"=>$alerts3[$i]


);

array_push($non_routine,$res);
$i++;	
}
if($flag==1){
	return response(json_encode(array("data"=>"Alerts should not be greater than Notification days","status_code"=>500)));
}

}
	
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		
		"notification_cycle"=>$notification,
		"first_alert"=>$alert1,
"second_alert"=>$alert2,
"third_alert"=>$alert3,
		
		"remarks"=>$remarks,
		"type"=>$type,
		"created_on"=>$created_on,
		"created_by"=>$user,
		"ids"=>$ids



	);
	
	$input_data=json_encode($input_data);
	$routine_checkup=array();
	
	
$count=DB::select('call check_for_unique_checkup_id(?)',array($input_data));
	//print_r($count);
	if(isset($count[0]->count) && $count[0]->count>=1){
return response(json_encode(array("data"=>"Vaccination already exists","status_code"=>500)));
	}
	
	$data=DB::select('call update_checkup_routine(?,?)',array($input_data,json_encode($non_routine)));
	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));
	

	
	

}

public function disable(Request $request,$id,$status){

	if($status=="active"){
		$stat="disabled";

	}else{
		$stat="active";
	}


	$data=DB::select('call disable_checkup(?,?)',array($id,$stat));
	

	
	     return \Redirect::route("master_routine_non_routine.home");





}

public function delete(Request $request,$id){

	


	$data=DB::select('call delete_checkup(?)',array($id));
	

	return redirect()->route('master_routine_non_routine.home', ['param' => $data[0]->count]);
	//return \Redirect::route("master_routine_non_routine.home");




}
}
