<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingDetail;

class BookingDetailController extends Controller
{
    public function show(BookingDetail $bookingDetail)
    {
        return response()->json($bookingDetail, 200);   
    }

    public function store(int $booking_id, int $service_id)
    {
        $bookingDetail = new BookingDetail();
        $bookingDetail->booking_id = $booking_id;
        $bookingDetail->service_id = $service_id;
        if ($bookingDetail->save()){
            return " Data Successfully Added ";
        }
    }
}
