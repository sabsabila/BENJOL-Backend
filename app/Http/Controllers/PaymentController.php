<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function showMyPayment($id)
    {
        $data = DB::table('bookings')
        ->select('payments.*','bookings.repairment_date', 'booking_details.service_cost', 'booking_details.repairment_note','booking_details.bengkel_note')
        ->join('payments', 'payments.booking_id', 'bookings.booking_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->where('bookings.user_id', auth('api')->account()->user->user_id)
        ->where('bookings.booking_id', $id)
        ->first();
        
        return response()->json(['payment' => $data]);
    }

    public function showBengkelPayment()
    {
        
        $data = DB::table('bookings')
        ->select('payments.*','bookings.repairment_date', 'booking_details.service_cost', 'booking_details.repairment_note','booking_details.bengkel_note', 'users.first_name', 'users.last_name', 'services.service_name')
        ->join('payments', 'payments.booking_id', 'bookings.booking_id')
        ->join('users', 'bookings.user_id', 'users.user_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('services', 'booking_details.service_id', 'services.service_id')
        ->where('bookings.bengkel_id', auth('api')->account()->bengkel->bengkel_id)
        ->orderBy('bookings.repairment_date', 'asc')
        ->get();
        return response()->json(['payments' => $data]);
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::find($id);

        $payment->status = $request->status;
        
        if ($payment->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }

    public function updateReceipt(Request $request)
    {
        $booking = auth('api')->account()->user->booking->sortByDesc('booking_id')->first();
        $payment = $booking->payment;
        $payment->receipt = $request->receipt;
        
        if ($payment->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }
}
