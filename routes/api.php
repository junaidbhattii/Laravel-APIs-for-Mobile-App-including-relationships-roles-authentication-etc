<?php

use App\Http\Controllers\auth\AuthenticationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\user\EditUserController;
use App\Http\Controllers\vendor\DriverController;
use App\Http\Controllers\vendor\RegistrationController;
use App\Http\Controllers\vendor\ServiceAreaController;
use App\Http\Controllers\vendor\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signup',[AuthenticationController::class,'Sign_Up']);

Route::post('login',[AuthenticationController::class,'Login']);

Route::post('changepassword',[AuthenticationController::class,'ChangePassword']);

//____________________Vendor-Registration______________________

Route::post('vendoradd',[RegistrationController::class,'VendorRegistration']);
//     ADD_DRIVER
Route::post('driveradd',[DriverController::class,'AddDriver']);
//     ADD_VEHICLE
Route::post('addvehicle',[VehicleController::class,'AddVehicle']);
//     ADD_SERVICE_AREAS
Route::post('addservicearea',[ServiceAreaController::class,'ServiceArea']);


//____________________User______________________

Route::post('edituser',[EditUserController::class,'EditUser']);


//____________________TRIP______________________

Route::post('trip',[TripController::class,'SearchTrip']);



