<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Validator;

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

    public function editVehicleType(Request $request)
    {
        $messages = [
            'fee.required' => 'El campo tarifa es requerido',
            'fee.integer' => 'El campo tarifa debe ser un número',
        ];

        $validator = Validator::make($request->all(), [
            'fee' => 'required|integer',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'code' => 422,
            ]);
        }

        $vehicleType = VehicleType::find($request->id);
        $vehicleType->fee = $request->fee;
        $vehicleType->save();

        return response()->json([
            'message' => 'Tarifa editada correctamente',
            'code' => 201,
        ]);
    }
}