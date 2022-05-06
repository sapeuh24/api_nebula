<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleUser;

class VehicleUserController extends Controller
{
    public static function getVehicleUsers($document_number)
    {
        $vehicleUsers = VehicleUser::where('document_number', $document_number)
        ->join('vehicle_types', 'vehicle_types.id', '=', 'vehicle_users.id_vehicle_type')
        ->select(
            'vehicle_users.vehicle_plate',
            'vehicle_users.vehicle_brand',
            'vehicle_users.vehicle_model',
            'vehicle_types.type',
        )
        ->get();

        return response()->json($vehicleUsers);
    }

    public static function storeVehicleToUser($data)
    {
        $vehicleUser = new VehicleUser();
        $vehicleUser->document_number = $data['document_number'];
        $vehicleUser->vehicle_plate = $data['vehicle_plate'];
        $vehicleUser->vehicle_brand = $data['brand'];
        $vehicleUser->vehicle_model = $data['model'];
        $vehicleUser->id_vehicle_type = $data['type'];
        $vehicleUser->save();

        return response()->json($vehicleUser, 201);
    }
}