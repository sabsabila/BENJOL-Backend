<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon;

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

    public function revenueCount(Request $request){
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $status = $request->status;
        $count = DB::table('booking_details')
                ->select(DB::raw('sum(booking_details.service_cost) as revenue_count'))
                ->join('bookings', 'bookings.booking_id', 'booking_details.booking_id')
                ->join('payments', 'payments.booking_id', 'booking_details.booking_id')
                ->where('payments.status', $status)
                ->where('bookings.bengkel_id', Auth::User()->bengkel->bengkel_id)
                ->whereMonth('bookings.repairment_date', $month)
                ->whereYear('bookings.repairment_date', $year)
                ->groupBy('bookings.bengkel_id')
                ->first();
        if($count != null){
            if($count->revenue_count == null)
                $count = null;
        }
        return response()->json(['count' => $count]);
    }
}
