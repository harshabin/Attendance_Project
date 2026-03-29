<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use DB;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function index(Request $request){

	$data=DB::table("students")->get();
	return view("students.index",compact('data'));

}

public function edit(Request $request){

	$data=DB::table("students")->get();
	return view("students.index",compact('data'));

}
}
