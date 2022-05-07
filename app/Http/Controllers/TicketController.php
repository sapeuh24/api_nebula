<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Ticket;
use App\Models\VehicleUser;
use App\Models\Parking;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TicketController extends Controller
{
    public static function storeTicket($data)
    {
        $messages = [
            'vehicle_plate.required' => 'El campo placa es requerido',
        ];

        $dt = Carbon::now();

        $validator = Validator::make($data->all(), [
            'vehicle_plate' => 'required',
        ], $messages);

        $parkind_id = Parking::find($data['parking_number_selected']);

        $ticket = new Ticket();
        $ticket->id_parking  = $parkind_id->id;
        $ticket->initial_time = $dt->toTimeString();
        $ticket->vehicle_plate  = $data['vehicle_plate'];
        $ticket->save();

        return response()->json($ticket);
    }

    public function finishTickect(Request $request)
    {
        $ticket = Ticket::where('id_parking', $request->id_parking)
        ->orderBy('id', 'desc')
        ->select('id', 'initial_time', 'vehicle_plate')
        ->first();

        $td = Carbon::now();
        $ticket->final_time = $td->toTimeString();

        $fee = VehicleUser::where('vehicle_plate', $ticket->vehicle_plate)
        ->join('vehicle_types', 'vehicle_types.id', 'vehicle_users.id_vehicle_type')
        ->select('vehicle_types.fee')
        ->first();

        $time_init = strtotime($ticket->initial_time);
        $time_final = strtotime($ticket->final_time);
        $totalDurationMinutes = ($time_final - $time_init) / 60;

        $discounts = Discount::pluck('minutes');

        $discount = '';
        for ($i = 0; $i < count($discounts); $i++) {
            if ($totalDurationMinutes > $discounts[$i]) {
                $discount = Discount::where('minutes', $discounts[$i])
                ->select('discount')
                ->first();
            }
        }

        if ($discount) {
            $fee_value = (int) $totalDurationMinutes * $fee->fee;
    
            $fee_discount = $fee_value * $discount->discount / 100;
    
            $ticket->total_value = $fee_value - $fee_discount;
            $ticket->discount_value = $fee_discount;
            $ticket->save();
        } else {
            $ticket->total_value = $totalDurationMinutes * $fee->fee;
            $ticket->discount_value = 0;
            $ticket->save();
        }
        

        $parking = Parking::find($request->id_parking);
        $parking->parking_ocupation = 0;
        $parking->save();

        $data = VehicleUser::where('vehicle_plate', $ticket->vehicle_plate)
        ->join('users', 'users.document_number', 'vehicle_users.document_number')
        ->join('vehicle_types', 'vehicle_types.id', 'vehicle_users.id_vehicle_type')
        ->select(
            'vehicle_users.document_number',
            'vehicle_users.vehicle_plate',
            'vehicle_users.vehicle_brand',
            'vehicle_users.vehicle_model',
            'vehicle_types.type',
            'users.name',
        )
        ->first();

        return response()->json([
            'ticket' => $ticket,
            'data' => $data,
            'code' => 201,
        ]);
    }
}