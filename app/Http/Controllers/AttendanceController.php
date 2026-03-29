<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class AttendanceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

 
//chrome://flags/#unsafely-treat-insecure-origin-as-secure
public function qr_code(Request $request){
$data=	DB::table('barcode_number')->get();
return view("attendance.qr_code",compact("data"));

	

}

public function attendance(Request $request){

	$data=[];
		
		return view("attendance.attendance",compact("data"));
	
	}
public function scanner(Request $request){
	$data=	DB::table('barcode_number')->get();
	return view("attendance.scanner",compact("data"));
	
		
	
	}
	



public function add(Request $request){

	DB::beginTransaction();
  $response = array();
   
  // check for required fields
  
	 $name= $request->post('name');
		  $address= $request->post('address');
		  $mobile= $request->post('mobile');
		  $attendance_no= $request->post('attendance_no');
		  $pwd= $request->post('pwd');
		
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
	 
		
	
		
		 if(!isset($name)||!isset($address)||!isset($mobile)||!isset($attendance_no)||!isset($pwd)){
		   return response(array("data"=>"All fileds are mandatory ","status_code"=>500));
		 }
  // session_start();
  // $data=DB::table("delivery_control")->where("mobile",$name)->get();
  // if(count($data)>0){
  //   return response(array("data"=>"mobile exists ","status_code"=>500));
  // }
  
  $insert_array=array(
  
  "name"=>$name,
  "mobile"=>$mobile,
  "attendance_no"=>$attendance_no,
  "pwd"=>$pwd,
  "created_on"=>$date,
  "address"=>$address,
  
  );
  try{
  DB::table('attendance')->insert($insert_array);
  
	DB::commit();
  
  }
	catch(\Exception $ex){ 
	//print_r(json_encode($ex));die();
	  return json_encode(array("data"=>$ex->errorInfo,"status_code"=>500));
	  // Note any method of class PDOException can be called on $ex.
	}
   
   return json_encode(array("data"=>"Successful","status_code"=>200));
   
  
  }
  




  public function update(Request $request){

	DB::beginTransaction();
  $response = array();
   
  // check for required fields
  
	 $name= $request->post('name');
	 $confirm_pwd= $request->post('confirm_pwd');
		  $address= $request->post('address');
		  $mobile= $request->post('mobile');
		  $attendance_no= $request->post('attendance_no');
		  $pwd= $request->post('pwd');
		  $id= $request->post('id');
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d H:i:s');
	 
		
	
		
		 if(!isset($name)||!isset($address)||!isset($mobile)||!isset($attendance_no)||!isset($pwd)){
		   return response(array("data"=>"All fileds are mandatory ","status_code"=>500));
		 }

		 if($pwd!=$confirm_pwd){
			return response(array("data"=>"Password should match","status_code"=>500));
		 }
  // session_start();
  // $data=DB::table("delivery_control")->where("mobile",$name)->get();
  // if(count($data)>0){
  //   return response(array("data"=>"mobile exists ","status_code"=>500));
  // }
  
  $insert_array=array(
  
  "name"=>$name,
  "mobile"=>$mobile,
  "attendance_no"=>$attendance_no,
  "pwd"=>$pwd,
  "modified_on"=>$date,
  "address"=>$address,
  
  );
  try{
  DB::table('attendance')->where("id",$id)->update($insert_array);
  
	DB::commit();
  
  }
	catch(\Exception $ex){ 
	//print_r(json_encode($ex));die();
	  return json_encode(array("data"=>$ex->errorInfo,"status_code"=>500));
	  // Note any method of class PDOException can be called on $ex.
	}
   
   return json_encode(array("data"=>"Successful","status_code"=>200));
   
  
  }
  



  public function update_attendance(Request $request){

	DB::beginTransaction();
  $response = array();
   
  // check for required fields
  
	 $user_id= $_SESSION['user_id'];
		date_default_timezone_set("Asia/Calcutta");
		$date = date('Y-m-d');
	 
		
	
	  
  // session_start();
  // $data=DB::table("delivery_control")->where("mobile",$name)->get();
  // if(count($data)>0){
  //   return response(array("data"=>"mobile exists ","status_code"=>500));
  // }
  
  $insert_array=array(
  
  "parent_id"=>$user_id,
 
  "created_on"=>$date,
  "status"=>"Present",
  
  );
  try{
  DB::table('attendance')->insert($insert_array);
  
	DB::commit();
  
  }
	catch(\Exception $ex){ 
	//print_r(json_encode($ex));die();
	  return json_encode(array("data"=>$ex->errorInfo,"status_code"=>500));
	  // Note any method of class PDOException can be called on $ex.
	}
   
   return json_encode(array("data"=>"Successful","status_code"=>200));
   
  
  }
  


  
public function add1(Request $request){
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

	if($name==""||$dob==""||$mobile_number==""||$address==""||$pin_code==""){
		return response(json_encode(array("data"=>"All * fields are required","status_code"=>500)));

	}

	if(!is_numeric($mobile_number) || strlen($mobile_number)!=10){
		return response(json_encode(array("data"=>"Mobile number should be numeric and 10 digits only","status_code"=>500)));

	}
	if(!isset($vaccination_id)){
		return response(json_encode(array("data"=>"Select vaccination","status_code"=>500)));

	}
	date_default_timezone_set("Asia/Kolkata");

			if(is_null($remarks)){
				$remarks="";

			}
			if(is_null($email_id)){
				$email_id="";

			}
		
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
		"attendance_type"=>"vaccination",
		"created_on"=>$created_on,
		"created_by"=>$user,
		"alt_mobile_number"=>$alt_mobile_number



	);
	$checkup=array();
	$i=0;
	foreach($vaccination_id as $vcc){
		$data=array(
			"id"=>$vcc,
			"name"=>$vaccination_name[$i++]

		);
		array_push($checkup, $data);

	}
	$checkup=json_encode($checkup);
	$input_data=json_encode($input_data);
	

	$data=DB::select('call add_attendance(?,?)',array($checkup,$input_data));
	 $data=DB::select("call get_sms_details()");

    $url=$data[0]->url;
    $text="Dear {#var#}, your child is registered for Vaccination Reminder. We will send you a message, whenever child is due for vaccination. We wish you a healthy & happy motherhood and child care with AV Multispeciality Hospital";
    $find="{#var#}";
    $result = preg_replace("/$find/",$name,$text,1);
    
    $result=urlencode($result);
    $url= str_replace("{#number}",$mobile_number,$url);
    $url= str_replace("{#message}",$result,$url);
    $url= str_replace("DLT_Templateid","1207166524326283343",$url);
    $curl_handle=curl_init();
    \Log::info($result);
     \Log::info($url);
  curl_setopt($curl_handle,CURLOPT_URL,$url);
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  curl_close($curl_handle);
  // if (empty($buffer)){
  //     print "Nothing returned from url.<p>";
  // }
  // else{
  //     print $buffer;
  // }
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public function get_attendance(Request $request){

  

	\DB::statement("SET SQL_MODE=''");
	$search=$request->post('search')['value'];
	  date_default_timezone_set("Asia/Calcutta");
		  $date = date('Y-m-d');
	
	$start=(int)$request->post('start');
	
	$length=(int)($request->post('length'));
	$from_date=$request->post('from_date');
	$to_date=$request->post('to_date');
	
	if(!isset($from_date)){
	  $from_date="1999-01-01 00:00:00";
	}else{
	  $from_date=$from_date." 00:00:00"; 
	}
	if(!isset($to_date)){
	  $to_date=$date." 23:59:59" ;
	}else{
	  $to_date=$to_date." 23:59:59"; 
	}
	
	if($search==""){
	try{
	$grand_data = DB::table('attendance')
	
	->join("registration","registration.id","attendance.parent_id")
	// ->where(function($q) use ($search,$from_date,$to_date) {
	
	//   $q->where('payment_details.created_on', '>=', $from_date)
	//   ->where('payment_details.created_on', '<=',  $to_date);
	//          ;
	//         })
	
	
	->get(); 
	
	
	
	
	}catch(Exception $e){
	  
	echo $e->getMessage();
	}
	
	try{
	$data =  DB::table('attendance')
	->select("attendance.status","attendance.created_on as  date","registration.*")
	->join("registration","registration.id","attendance.parent_id")
	->take($length)->skip($start)->orderby("id","desc")->get(); 
	
	foreach ($data as $dt) {
	
	
	//$dt->delete=route('delete_attendance',['id'=>$dt->id]);
	//$dt->edit=route('edit_attendance',['id'=>$dt->id]);
	
	
	}
	
	echo json_encode(array(
	"data"=>$data,
	"recordsTotal"=>count($grand_data),
	"recordsFiltered"=>count($grand_data)
	));
	
	
	}catch(Exception $e){
	  
	echo $e->getMessage();
	}
	
	
	}else{
	
	
	
	try{
	$grand_data =DB::table('attendance')
	
	->select("attendance.status","attendance.created_on as  date","registration.*")
	->join("registration","registration.id","attendance.parent_id")
	->where(function($q) use ($search) {
	
			  $q->orWhere('registration.name', 'LIKE', '%'. $search . '%')
			  ->orWhere('registration.mobile', 'LIKE', '%'. $search . '%')
			  ->orWhere('registration.registartion_no', 'LIKE', '%'. $search . '%')
			 ;
			})
	 
	->get(); 
	
	
	
	
	}catch(Exception $e){
	  
	echo $e->getMessage();
	}
	
	try{
	$data = DB::table('attendance')
	->select("attendance.status","attendance.created_on as  date","registration.*")
	->join("registration","registration.id","attendance.parent_id")
	->where(function($q) use ($search) {
	
	  $q->orWhere('registration.name', 'LIKE', '%'. $search . '%')
	  ->orWhere('registration.mobile', 'LIKE', '%'. $search . '%') 
	  ->orWhere('registration.registartion_no', 'LIKE', '%'. $search . '%');
			})
	->take($length)->skip($start)->orderby("id","desc")->get(); 
	foreach ($data as $dt) {
	
	 // $dt->edit=route('edit_attendance',['id'=>$dt->id]);
	  }
	
	echo json_encode(array(
	"data"=>$data,
	"recordsTotal"=>count($grand_data),
	"recordsFiltered"=>count($grand_data)
	));
	
	
	
	}catch(Exception $e){
	  
	echo $e->getMessage();
	}
	
	
	
	
	}
	
	
	
	
	
	}
	
	
	
public function view(Request $request,$id){
	
	$data=DB::select('call get_attendances_id(?)',array($id));
	$registered_for=DB::select('call get_attendance_for_id(?)',array($id));
	
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

	return view("attendance.view",compact('data','checkup_data'));

}

public function edit_attendance(Request $request,$id){
	$data=DB::table("attendance")
  
	->where("attendance.id",$id)->get();
	
 
   return view("attendance.edit",compact("data","id"));
  
  }
  

public function update1(Request $request){
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
	if($name==""||$dob==""||$mobile_number==""||$address==""||$pin_code==""){
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
		"dob"=>$dob,
		"mobile_number"=>$mobile_number,
		"email_id"=>$email_id,
		"address"=>$address,
		"pin_code"=>$pin_code,
		"remarks"=>$remarks,
		"attendance_type"=>"vaccination",
		"updated_on"=>$created_on,
		"ids"=>$id,
		"alt_mobile_number"=>$alt_mobile_number



	);
	$checkup=array();
	$i=0;
	foreach($vaccination_id as $vcc){
		$data=array(
			"id"=>$vcc,
			"name"=>$vaccination_name[$i++]

		);
		array_push($checkup, $data);

	}
	$checkup=json_encode($checkup);
	$input_data=json_encode($input_data);
	// print_r(json_encode($input_data));
	// print_r(json_encode($checkup));
	// die();
	

	$data=DB::select('call update_attendance(?,?)',array($checkup,$input_data));
	

	
	return response(json_encode(array("data"=>"Successful","status_code"=>200)));

}

public function disable(Request $request,$id,$status){

	if($status=="active"){
		$stat="disabled";

	}else{
		$stat="active";
	}


	$data=DB::select('call disable_attendance(?,?)',array($id,$stat));
	

	
	     return \Redirect::route("attendance.vaccination");





}

public function delete(Request $request,$id){

	


	$data=DB::select('call delete_attendance(?)',array($id));
	

	
	return \Redirect::route("attendance.vaccination");




}
public function checkups(Request $request,$id){
	$checkups=DB::select('call get_attendance_for_id("'.$id.'")');
	$data=DB::select('call get_attendances_id(?)',array($id));

	
	return view("attendance.checkups",compact("data","checkups"));

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
		"attendance_id"=>$ids,
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
