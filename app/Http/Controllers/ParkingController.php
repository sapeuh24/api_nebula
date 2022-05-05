<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

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
        $parking = Parking::where('parking_mumber', $data['parking_number_selected'])->first();

        return $parking;
    }
}