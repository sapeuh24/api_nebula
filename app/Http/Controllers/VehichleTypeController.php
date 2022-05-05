<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleType;

class VehichleTypeController extends Controller
{
    public function getVehiclesTypes()
    {
        $vehiclesTypes = VehicleType::get();

        return response()->json([
            'vehiclesTypes' => $vehiclesTypes,
            'code' => 201,
        ]);
    }
}