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

public function check_login(Request $request){

$user_name=$request->post("user_name");	
$pwd=$request->post("pwd");	

$data=DB::select('call query_login("'.$user_name.'","'.$pwd.'")');

if(count($data)>=1){

 return response(json_encode(array("data"=>$data,"status_code"=>200)));
}else{
	 return response(json_encode(array("data"=>"Invalid Login","status_code"=>500)));
}

	

}
}
