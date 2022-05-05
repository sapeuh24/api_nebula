<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\VehichleTypeController;

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

Route::post('create_discount', [DiscountController::class, 'createDiscount']);
Route::post('edit_discount', [DiscountController::class, 'editDiscount']);
Route::post('delete_discount', [DiscountController::class, 'deleteDiscount']);

Route::get('get_vehicle_type', [VehichleTypeController::class, 'getVehiclesTypes']);

Route::post('create_user', [UserController::class, 'createUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});