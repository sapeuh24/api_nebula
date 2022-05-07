<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\VehicleUser;

class ReportingController extends Controller
{
    public function getParkingMoreUsed(Request $request)
    {
        if ($request->today) {
            $dateFrom = date('Y-m-d:00:00:00');
            $dateTo = date('Y-m-d:23:59:59');
        } else {
            $dateFrom = $request->from.':00:00:00';
            $dateTo = $request->to.':23:59:59';
        }

        $count_tickets = Ticket::whereBetween('created_at', [$dateFrom, $dateTo])
        ->groupBy('id_parking')
        ->orderBy('total', 'desc')
        ->selectRaw('count(*) as total, id_parking')
        ->selectRaw('parking_type')
        ->join('parkings', 'tickets.id_parking', 'parkings.id')
        ->first();

        return response()->json([
            'parkings' => $count_tickets
        ]);
    }

    public function getTransactionTicketsByVehicle(Request $request)
    {
        if ($request->today) {
            $dateFrom = date('Y-m-d:00:00:00');
            $dateTo = date('Y-m-d:23:59:59');
        } else {
            $dateFrom = $request->from.':00:00:00';
            $dateTo = $request->to.':23:59:59';
        }

        $tickets = Ticket::whereBetween('created_at', [$dateFrom, $dateTo])
        ->select('vehicle_plate')
        ->groupBy('vehicle_plate')
        ->get();

        $data = Ticket::whereIn('vehicle_plate', $tickets)->get();

        return response()->json([
            'tickets' => $data
        ]);
    }

    public function getTikectsByVehicleType(Request $request)
    {
        if ($request->today) {
            $dateFrom = date('Y-m-d:00:00:00');
            $dateTo = date('Y-m-d:23:59:59');
        } else {
            $dateFrom = $request->from.':00:00:00';
            $dateTo = $request->to.':23:59:59';
        }
               
        $tickets = VehicleUser::select('vehicle_plate', 'vehicle_brand', 'vehicle_model', 'type')
        ->join('vehicle_types', 'vehicle_types.id', 'vehicle_users.id_vehicle_type')
        ->with(['tickets' => function ($t) use ($dateFrom, $dateTo) {
            $t->select('id', 'discount_value', 'initial_time', 'final_time', 'total_value', 'vehicle_plate');
            $t->where('final_time', '!=', null);
            $t->whereBetween('created_at', [$dateFrom, $dateTo]);
        }])->get();
       

        return response()->json([
            'tickets' => $tickets
        ]);
    }

    public function getTotalValueTickets(Request $request)
    {
        if ($request->today) {
            $dateFrom = date('Y-m-d:00:00:00');
            $dateTo = date('Y-m-d:23:59:59');
        } else {
            $dateFrom = $request->from.':00:00:00';
            $dateTo = $request->to.':23:59:59';
        }

        $tickets = Ticket::whereBetween('created_at', [$dateFrom, $dateTo])
        ->selectRaw('sum(total_value) as total')
        ->selectRaw('count(id) as total_tickets')
        ->get();

        return response()->json([
            'tickets' => $tickets
        ]);
    }
}