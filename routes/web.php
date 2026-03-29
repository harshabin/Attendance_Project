<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RegistrationCheckupController;
use App\Http\Controllers\MasterInfantVaccination;
use App\Http\Controllers\MasterRoutineNonRoutine;
use App\Http\Controllers\User;
use App\Http\Controllers\Settings;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('website.welcome');
// });


//Vaccination Registration
Route::get('/',[LoginController::class,'index'])->name('login');
Route::get('logout',[LoginController::class,'logout'])->name('logout');
Route::any('/login/check_login',[LoginController::class,'check_login'])->name('check_login');
Route::any('/dashboard/dashboard',[DashboardController::class,'dashboard'])->name('dashboard')->middleware('auth');
Route::any('/registration',[RegistrationController::class,'registration'])->name('registration')->middleware('auth');;
Route::any('/scanner',[RegistrationController::class,'scanner'])->name('scanner')->middleware('auth');;
Route::any('/add',[RegistrationController::class,'add'])->name('add');
Route::any('/get_registrations',[RegistrationController::class,'get_registrations'])->name('get_registrations')->middleware('auth');
Route::any('/registration/view/{id}',[RegistrationController::class,'view'])->name('registration.view')->middleware('auth');
Route::any('/edit_registration/{id}',[RegistrationController::class,'edit_registration'])->name('edit_registration')->middleware('auth');
Route::any('/update',[RegistrationController::class,'update'])->name('update');
Route::any('/registration/disable/{id}/{status}',[RegistrationController::class,'disable'])->name('registration.disable')->middleware('auth');
Route::any('/registration/delete/{id}',[RegistrationController::class,'delete'])->name('registration.delete')->middleware('auth');
Route::any('/registration/add_checkups',[RegistrationController::class,'add_checkups'])->name('registration.add_checkups');
Route::any('/registration/delete_checkups/{id}',[RegistrationController::class,'delete_checkups'])->name('registration.delete_checkups')->middleware('auth');
Route::any('/qr_code',[RegistrationController::class,'qr_code'])->name('qr_code')->middleware('auth');
Route::any('/update_attendance',[AttendanceController::class,'update_attendance'])->name('update_attendance')->middleware('auth');
Route::any('/attendance',[AttendanceController::class,'attendance'])->name('attendance')->middleware('auth');;
Route::any('/get_attendance',[AttendanceController::class,'get_attendance'])->name('get_attendance')->middleware('auth');


// //Checkup Registration
// Route::any('/registration_checkup/checkup',[RegistrationCheckupController::class,'checkup'])->name('registration_checkup.vaccination')->middleware('auth');
// Route::any('/registration_checkup/get_registrations',[RegistrationCheckupController::class,'get_registrations'])->name('registration_checkup.get_registrations')->middleware('auth');
// Route::any('/registration_checkup/add',[RegistrationCheckupController::class,'add'])->name('registration_checkup.add');
// Route::any('/registration_checkup/view/{id}',[RegistrationCheckupController::class,'view'])->name('registration_checkup.view')->middleware('auth');
// Route::any('/registration_checkup/edit/{id}',[RegistrationCheckupController::class,'edit'])->name('registration_checkup.edit')->middleware('auth');
// Route::any('/registration_checkup/update',[RegistrationCheckupController::class,'update'])->name('registration_checkup.update');
// Route::any('/registration_checkup/disable/{id}/{status}',[RegistrationCheckupController::class,'disable'])->name('registration_checkup.disable')->middleware('auth');
// Route::any('/registration_checkup/delete/{id}',[RegistrationCheckupController::class,'delete'])->name('registration_checkup.delete')->middleware('auth');
// Route::any('/registration_checkups/checkups/{id}',[RegistrationCheckupController::class,'checkups'])->name('registration_checkups.checkups')->middleware('auth');
// Route::any('/registration_checkups/get_checkups_history/',[RegistrationCheckupController::class,'get_checkups_history'])->name('registration_checkups.get_checkups_history');
// Route::any('/registration_checkup/add_checkups',[RegistrationCheckupController::class,'add_checkups'])->name('registration_checkup.add_checkups');
// Route::any('/registration_checkups/delete_checkups/{id}',[RegistrationCheckupController::class,'delete_checkups'])->name('registration_checkup.delete_checkups')->middleware('auth');



// //Master Infant Vaccination
// Route::any('/master_infant_vaccination/home',[MasterInfantVaccination::class,'home'])->name('master_infant_vaccination.home')->middleware('auth');
// Route::any('/master_infant_vaccination/get_master',[MasterInfantVaccination::class,'get_master'])->name('master_infant_vaccination.get_master')->middleware('auth');
// Route::any('/master_infant_vaccination/add',[MasterInfantVaccination::class,'add'])->name('master_infant_vaccination.add');
// Route::any('/master_infant_vaccination/view/{id}',[MasterInfantVaccination::class,'view'])->name('master_infant_vaccination.view')->middleware('auth');
// Route::any('/master_infant_vaccination/edit/{id}',[MasterInfantVaccination::class,'edit'])->name('master_infant_vaccination.edit')->middleware('auth');
// Route::any('/master_infant_vaccination/update',[MasterInfantVaccination::class,'update'])->name('master_infant_vaccination.update');
// Route::any('/master_infant_vaccination/disable/{id}/{status}',[MasterInfantVaccination::class,'disable'])->name('master_infant_vaccination.disable')->middleware('auth');
// Route::any('/master_infant_vaccination/delete/{id}',[MasterInfantVaccination::class,'delete'])->name('master_infant_vaccination.delete')->middleware('auth');



// //Master Routine/Non Routine
// Route::any('/master_routine_non_routine/home',[MasterRoutineNonRoutine::class,'home'])->name('master_routine_non_routine.home')->middleware('auth');
// Route::any('/master_routine_non_routine/get_master',[MasterRoutineNonRoutine::class,'get_master'])->name('master_routine_non_routine.get_master')->middleware('auth');
// Route::any('/master_routine_non_routine/add',[MasterRoutineNonRoutine::class,'add'])->name('master_routine_non_routine.add');
// Route::any('/master_routine_non_routine/view/{id}',[MasterRoutineNonRoutine::class,'view'])->name('master_routine_non_routine.view')->middleware('auth');
// Route::any('/master_routine_non_routine/edit/{id}',[MasterRoutineNonRoutine::class,'edit'])->name('master_routine_non_routine.edit')->middleware('auth');
// Route::any('/master_routine_non_routine/update',[MasterRoutineNonRoutine::class,'update'])->name('master_routine_non_routine.update');
// Route::any('/master_routine_non_routine/disable/{id}/{status}',[MasterRoutineNonRoutine::class,'disable'])->name('master_routine_non_routine.disable')->middleware('auth');
// Route::any('/master_routine_non_routine/delete/{id}',[MasterRoutineNonRoutine::class,'delete'])->name('master_routine_non_routine.delete')->middleware('auth');




// //Users
// Route::any('/users/home',[User::class,'home'])->name('users.home')->middleware('auth');
// Route::any('/users/get_users',[User::class,'get_users'])->name('users.get_users')->middleware('auth');
// Route::any('/users/add',[User::class,'add'])->name('users.add');
// Route::any('/users/delete/{id}',[User::class,'delete'])->name('users.delete')->middleware('auth');
// Route::any('/users/edit/{id}',[User::class,'edit'])->name('users.edit')->middleware('auth');
// Route::any('/users/update',[User::class,'update'])->name('users.update');
// Route::any('/users/disable/{id}/{status}',[User::class,'disable'])->name('users.disable')->middleware('auth');



// //Settings
// Route::any('/settings/sms/edit',[Settings::class,'sms_edit'])->name('settings.sms_edit')->middleware('auth');
// Route::any('/settings/smtp/edit',[Settings::class,'smtp_edit'])->name('settings.smtp_edit')->middleware('auth');
// Route::any('/settings/smtp/update',[Settings::class,'smtp_update'])->name('settings.smtp_update');
// Route::any('/settings/sms/update',[Settings::class,'sms_update'])->name('settings.sms_update');
// Route::any('/settings/accessebility',[Settings::class,'accessebility'])->name('settings.accessebility');
// Route::any('/settings/get_all_users',[Settings::class,'get_all_users'])->name('settings.get_all_users');
// Route::any('/settings/get_user_accessibility',[Settings::class,'get_user_accessibility'])->name('settings.get_user_accessibility');
// Route::any('/settings/user_accessibility_update',[Settings::class,'user_accessibility_update'])->name('settings.user_accessibility_update');
// Route::any('/settings/run_cron',[Settings::class,'run_cron'])->name('settings.run_cron');