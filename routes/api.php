<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\VehichleTypeController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('get_parking', [ParkingController::class, 'getParking']);
Route::get('validate_user/{document_number}', [UserController::class, 'validateUser']);
Route::post('store_parking_with_plate', [ParkingController::class, 'storeParkingWithPlate']);



Route::post('get_parking_more_used', [ReportingController::class, 'getParkingMoreUsed']);
Route::post('get_transaction_tickets_by_vehicle', [ReportingController::class, 'getTransactionTicketsByVehicle']);
Route::post('get_tickets_by_vehicle_type', [ReportingController::class, 'getTikectsByVehicleType']);
Route::post('get_total_value_tickets', [ReportingController::class, 'getTotalValueTickets']);


Route::get('get_discount', [DiscountController::class, 'getDiscounts']);
Route::post('create_discount', [DiscountController::class, 'createDiscount']);
Route::post('edit_discount', [DiscountController::class, 'editDiscount']);
Route::post('delete_discount', [DiscountController::class, 'deleteDiscount']);

Route::get('get_vehicle_type', [VehichleTypeController::class, 'getVehiclesTypes']);
Route::post('edit_vehicle_type', [VehichleTypeController::class, 'editVehicleType']);

Route::post('finish_ticket', [TicketController::class, 'finishTickect']);

Route::post('create_user', [UserController::class, 'createUser']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});