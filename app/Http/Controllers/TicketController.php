<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public static function storeTicket(Request $request)
    {
        $ticket = new Ticket();
        $ticket->id_vehicle_user = $request->id_vehicle_user;
        $ticket->id_parking = $request->id_parking;
        $ticket->save();

        return response()->json($ticket, 201);
    }
}