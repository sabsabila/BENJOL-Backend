<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingDetail;

class BookingDetailController extends Controller
{

    public function store(int $booking_id, int $service_id, String $repairment_note)
    {
        $bookingDetail = new BookingDetail();
        $bookingDetail->booking_id = $booking_id;
        $bookingDetail->service_id = $service_id;
        $bookingDetail->repairment_note = $repairment_note;
        if ($bookingDetail->save()){
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }

    public function update(Request $request, $id)
    {
        $bookingDetail = BookingDetail::where('booking_id', $id)->first();
        $bookingDetail->bengkel_note = $request->bengkel_note;
        $bookingDetail->service_cost = $request->service_cost;
        if ($bookingDetail->save()){
            return response()->json([ 'message' => "Data Successfully Udated"]);
        }
    }
}
