<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\VehicleUser;
use App\Http\Controllers\TicketController;

class ParkingController extends Controller
{
    public function getParking()
    {
        $parkings = Parking::get();

        return response()->json([
            'parkings_a' => $parkings->where('parking_type', 'A'),
            'parkings_b' => $parkings->where('parking_type', 'B'),
            'parkings_m' => $parkings->where('parking_type', 'M'),
            'code' => 201,
        ]);
    }

    public static function validateParking($data)
    {
        $parking_type_to_select = '';
        if ($data['type'] == 1) {
            $parking_type_to_select = 'A';
        } elseif ($data['type'] == 2) {
            $parking_type_to_select = 'B';
        } elseif ($data['type'] == 3) {
            $parking_type_to_select = 'M';
        }

        $parkings_avaliables = Parking::where('parking_type', $parking_type_to_select)
            ->where('parking_ocupation', 0)
            ->pluck('id')->toArray();

        $parking = '';
        if ($data->random == true) {
            $parking = Parking::find($parkings_avaliables[array_rand($parkings_avaliables)]);
            $parking->parking_ocupation = 1;
            $parking->save();
            return $parking;
        } else {
            $parking = Parking::where('parking_number', $data['parking_number_selected'])->first();
            $parking->parking_ocupation = 1;
            $parking->save();
        }
        return $parking;
    }

    public function storeParkingWithPlate(Request $request)
    {
        $tipe= VehicleUser::where('vehicle_plate', $request['vehicle_plate'])
        ->select('id_vehicle_type')
        ->first();
        $request['type'] = $tipe->id_vehicle_type;
        
        $parking = $this->validateParking($request);
        
        $request['parking_number_selected'] = $parking->id;
        $ticket = TicketController::storeTicket($request);

        return response()->json([
            'parking' => $parking,
            'ticket' => $ticket->original,
            'code' => 201,
        ]);
    }
}