<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\VehicleUserController;
use App\Http\Controllers\ParkingController;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function createUser(Request $request)
    {
        $messages = [
            'name.required' => 'El campo nombre es requerido',
            'name.min' => 'El campo nombre debe ser mayor a 3 caracteres',
            'name.max' => 'El campo nombre debe ser menor a 50 caracteres',
            'document_number.required' => 'El campo apellido es requerido',
            'document_number.min' => 'El campo apellido debe ser mayor a 3 caracteres',
            'document_number.max' => 'El campo apellido debe ser menor a 50 caracteres',
            'document_number.integer' => 'El campo apellido debe ser un número',
        ];

        $validator = Validator::make($request->all(), [
            'document_number' => 'required|min:3|max:50|integer',
            'name' => 'required|min:3|max:50',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'code' => 422,
            ]);
        }

        $user = new User();
        $user->document_number = $request->document_number;
        $user->name = $request->name;
        $user->save();

        $vehicle_user = VehicleUserController::storeVehicleToUser($request);
        $parking = ParkingController::validateParking($request);

        return response()->json([
            'user' => $user,
            'vehicle_user' => $vehicle_user,
            'parking' => $parking,
            'code' => 201,
        ]);
    }

    public function validateUser(Request $request)
    {
        $user = User::where('document_number', $request->document_number)->first();

        if ($user) {
            $vehicles = VehicleUserController::getVehicleUsers($user->document_number);
            return response()->json([
                'user' => $user,
                'vehicles' => $vehicles,
                'code' => 201,
            ]);
        } else {
            return response()->json(['message' => 'El usuario aun no existe', 'code' => 404]);
        }
    }
}