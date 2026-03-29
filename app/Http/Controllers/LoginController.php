<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function index(Request $request){

	
	return view("login.login");

}


public function update_change_password(Request $request){
	$user_name=$_SESSION['user_name'];
	$current_pwd=$request->post("current_pwd");	
	$pwd=$request->post("new_pwd");	
	$confirm_pwd=$request->post("confirm_pwd");	

if(!isset($pwd)){
	return response(json_encode(array("data"=>"Password is required","status_code"=>500)));
}


	$data=DB::table("members")->where(array(
		"mobile"=>$user_name,
		
		"pwd"=>($current_pwd)
	))->get();

if(!isset($data)||count($data)<=0){
	return response(json_encode(array("data"=>"Invalid Current Password","status_code"=>500)));
}
if($confirm_pwd!=$pwd){
	return response(json_encode(array("data"=>"Password mismatch","status_code"=>500)));
}
$data=DB::table("members")->where(array(
	"mobile"=>$user_name
))->update(array("pwd"=>$pwd));

return response(json_encode(array("data"=>"Successful","status_code"=>200)));

	}


public function change_password(Request $request){
	return view("login.change_password");
}



public function check_login(Request $request){

$user_name=$request->post("user_name");	
$pwd=$request->post("pwd");	

$data=DB::table("registration")->where(array(
	"mobile"=>$user_name,
 
	 
	"pwd"=>($pwd)
))->get();

if(count($data)>=1){

	// if($data[0]->status=="inactive"){
	// 		 return response(json_encode(array("data"=>"User is Inactive","status_code"=>500)));

	// }
	
	session_start();
	
	$_SESSION['user_name']=$data[0]->mobile;
	$_SESSION['first_name']=$data[0]->name;
$_SESSION['user_id']=$data[0]->id;
	$_SESSION['roles']=$data[0]->role;
	$barcode=DB::table("barcode_number")->get();
	$_SESSION['number']=$barcode[0]->number;

	// $menu_array=DB::table("admin_accessibility")->where("parent_id",$data[0]->id)->get();

 // $menu = array(); 

 //      foreach($menu_array as $d)
 //      {
 //            $menu[]=$d->menu;   
 //      }

	// $_SESSION['user_accessibility']=",".implode(",",$menu);



	//echo $_SESSION['user_accessibility'];die();
    date_default_timezone_set("Asia/Calcutta");
      $date = date('Y-m-d H:i:s');


// DB::table("admin")->where(array(
// 	"email"=>$user_name,

// ))->update(array("last_login"=>$date));

//       $ip=$this->get_client_ip();
//       $device=getenv('COMPUTERNAME');
// DB::table("login_history")->insert(array(
// "user_id"=>$data[0]->email,
// "logged_in"=>$date,

// "ip_address"=>$ip,
// "device"=>$device,
// ));

	
	

 return response(json_encode(array("data"=>$data,"status_code"=>200)));

}else{

	 return response(json_encode(array("data"=>"Invalid Login","status_code"=>500)));
}

	

}
public function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

public function logout(Request $request){
	session_start();
	
	    date_default_timezone_set("Asia/Calcutta");
  
unset($_SESSION['user_name']);
	unset($_SESSION['name']);
	unset($_SESSION['roles']);
	unset($_SESSION['user_accessibility']);
	session_destroy();
	 return redirect('/');

}
}
