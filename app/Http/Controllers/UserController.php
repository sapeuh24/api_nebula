<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\VehicleUserController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            'document_number.required' => 'El campo número de documento es requerido',
            'document_number.min' => 'El campo número de documento debe ser mayor a 3 caracteres',
            'document_number.integer' => 'El campo número de documento debe ser un número',
            'document_number.unique' => 'El campo número de documento debe ser único',
            'vehicle_plate.unique' => 'El campo placa debe ser único',

        ];

        $validator = Validator::make($request->all(), [
            'document_number' => 'required|min:3|integer|unique:users',
            'name' => 'required|min:3|max:50',
            'vehicle_plate' => 'unique:vehicle_users',
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
        $ticket = TicketController::storeTicket($request);

        return response()->json([
                'user' => $user,
                'vehicle_user' => $vehicle_user,
                'parking' => $parking,
                'ticket' => $ticket,
                'code' => 201,
                'message' => 'Se ha asignado el parqueadero correctamente',
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