<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class RegistrationCheckupController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function checkup(Request $request){
	$type="vaccination";

	$data=DB::select('call fetch_checkup_other("'.$type.'")');

	
	return view("registration_checkup.checkup",compact("data"));

}

public function checkups(Request $request,$id){
	$checkups=DB::select('call get_registration_for_id("'.$id.'")');
	$data=DB::select('call get_registrations_id(?)',array($id));

	
	return view("registration_checkup.checkups",compact("data","checkups"));

}

public function add(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("name");
	$dob=$request->post("dob");
	$mobile_number=$request->post("mobile_number");
	$email_id=$request->post("email_id");
	$address=$request->post("address");
    $pin_code=$request->post("pin_code");
	$remarks=$request->post("remarks");

	$vaccination_id=$request->post("vaccination_id");
	$vaccination_name=$request->post("vaccination_name");
	$alt_mobile_number=$request->post("alt_mobile_number");

	if($name==""||$mobile_number==""||$address==""||$pin_code==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	if(!is_numeric($mobile_number) || strlen($mobile_number)!=10){
		return response(json_encode(array("data"=>"Mobile number should be numeric and 10 digits only","status_code"=>500)));

	}
	if(!isset($vaccination_id)){
		return response(json_encode(array("data"=>"Select vaccination","status_code"=>500)));

	}
	
			if(is_null($remarks)){
				$remarks="";

			}
			if(is_null($email_id)){
				$email_id="";

			}
		
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	$input_data=array(
		"name"=>$name,
		"dob"=>$dob,
		"mobile_number"=>$mobile_number,
		"email_id"=>$email_id,
		"address"=>$address,
		"pin_code"=>$pin_code,
		"remarks"=>$remarks,
		"registration_type"=>"checkup",
		"created_on"=>$created_on,
		"created_by"=>$user,
		"alt_mobile_number"=>$alt_mobile_number



	);
	$checkup=array();
	$i=0;
	foreach($vaccination_id as $vcc){
		$data=array(
			"id"=>$vcc,
			

		);
		array_push($checkup, $data);

	}
	$checkup=json_encode($checkup);
	$input_data=json_encode($input_data);
	

	$data=DB::select('call add_registration(?,?)',array($checkup,$input_data));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}
public function get_registrations(Request $request){
	$start=$request->post("start");
	$length=$request->post("length");
	$search=($request->post("search"))['value'];
	
	$type="checkup";
	$data=DB::select('call get_registrations(?,?,?,?)',array($start,$length,$search,$type));
	$total=DB::select('call get_registrations_total(?,?)',array($type,$search));


	echo json_encode(array(
"data"=>$data,
"recordsTotal"=>$total[0]->total,
"recordsFiltered"=>$total[0]->total
));


}

public function view(Request $request,$id){
	
	$data=DB::select('call get_registrations_id(?)',array($id));
	$registered_for=DB::select('call get_registration_for_id(?)',array($id));
	
	$checkup_data=DB::select('call fetch_checkup_other(?)',array("vaccination"));
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

	return view("registration_checkup.view",compact('data','checkup_data'));

}
public function edit(Request $request,$id){
	
	$data=DB::select('call get_registrations_id(?)',array($id));
	$registered_for=DB::select('call get_registration_for_id(?)',array($id));
	
	$checkup_data=DB::select('call fetch_checkup_other(?)',array("vaccination"));
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

	return view("registration_checkup.edit",compact('data','checkup_data'));

}



public function update(Request $request){
	session_start();
	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$name=$request->post("name");
	$dob=$request->post("dob");
	$mobile_number=$request->post("mobile_number");
	$email_id=$request->post("email_id");
	$address=$request->post("address");
    $pin_code=$request->post("pin_code");
	$remarks=$request->post("remarks");
	$id=$request->post("ids");

	$vaccination_id=$request->post("vaccination_id");
	$vaccination_name=$request->post("vaccination_name");

$alt_mobile_number=$request->post("alt_mobile_number");

	if($name==""||$mobile_number==""||$address==""||$pin_code==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}
	if(!is_numeric($mobile_number) || strlen($mobile_number)!=10){
		return response(json_encode(array("data"=>"Mobile number should be numeric and 10 digits only","status_code"=>500)));

	}
	if(!isset($vaccination_id)){
		return response(json_encode(array("data"=>"Select vaccination","status_code"=>500)));

	}
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];

	$input_data=array(
		"name"=>$name,
		"dob"=>"2022-01-01",
		"mobile_number"=>$mobile_number,
		"email_id"=>$email_id,
		"address"=>$address,
		"pin_code"=>$pin_code,
		"remarks"=>$remarks,
		"registration_type"=>"vaccination",
		"updated_on"=>$created_on,
		"ids"=>$id,
			"alt_mobile_number"=>$alt_mobile_number



	);
	$checkup=array();
	$i=0;
	foreach($vaccination_id as $vcc){
		$data=array(
			"id"=>$vcc,
			//"name"=>""

		);
		array_push($checkup, $data);

	}
	$checkup=json_encode($checkup);
	$input_data=json_encode($input_data);
	// print_r(json_encode($input_data));
	// print_r(json_encode($checkup));
	// die();
	

	$data=DB::select('call update_registration(?,?)',array($checkup,$input_data));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public function disable(Request $request,$id,$status){

	if($status=="active"){
		$stat="disabled";

	}else{
		$stat="active";
	}


	$data=DB::select('call disable_registration(?,?)',array($id,$stat));
	

	
	     return \Redirect::route("registration_checkup.vaccination");





}

public function delete(Request $request,$id){

	


	$data=DB::select('call delete_registration(?)',array($id));
	

	
	return \Redirect::route("registration_checkup.vaccination");




}

public function delete_checkups(Request $request,$id){

	


	$data=DB::select('call delete_checkups_history(?)',array($id));
	

	
	return back();



}


public function get_checkups_history(Request $request){
	//echo 1;die();
	$start=$request->post("start");
	$length=$request->post("length");
	$search=($request->post("search"))['value'];
	$patient_id=$request->post("patient_id");
	
	
	$data=$this->CallRaw('get_checkups_history',array($start,$length,$search,$patient_id));
	
//print_r($data);

	echo json_encode(array(
"data"=>$data[1],
"recordsTotal"=>$data[0][0]->total,
"recordsFiltered"=>$data[0][0]->total
));


}
public function add_checkups(Request $request){
	session_start();

	if(!isset($_SESSION['user_name'])){
		return response(json_encode(array("data"=>"Session Expired","status_code"=>404)));
	}
	

	$checkup_date=$request->post("checkup_date");
	$doctor_name=$request->post("doctor_name");
	$remarks=$request->post("remarks");
	$ids=$request->post("ids");
	
	$vaccination_id=$request->post("vaccination_id");
	$vaccination_name=$request->post("vaccination_name");

	
	if(!isset($vaccination_id)){
		return response(json_encode(array("data"=>"Select vaccination","status_code"=>500)));

	}
	date_default_timezone_set("Asia/Kolkata");
	$created_on=date("Y-m-d H:i:s");
	$user=$_SESSION['user_name'];
	//print_r($vaccination_id);
	$checkup="";
	$i=0;
	foreach($vaccination_id as $vcc){
		//$checkup=$vaccination_name[$i++];
		
		$input_data=array(
		"checkup_date"=>$checkup_date,
		"doctor_name"=>$doctor_name,
		
		"remarks"=>$remarks,
		"registration_id"=>$ids,
		"created_on"=>$created_on,
		"created_by"=>$_SESSION['user_name'],
		"checkup"=>$vcc



	);

DB::select('call add_checkups_history(?)',array(json_encode($input_data)));
	
	}
	

	

	
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
}
