<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;

class PaymentController extends Controller
{
    public function showMyPayment($id)
    {
        $data = DB::table('bookings')
        ->select('payments.*','bookings.repairment_date', 'booking_details.service_cost', 'booking_details.repairment_note','booking_details.bengkel_note')
        ->join('payments', 'payments.booking_id', 'bookings.booking_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->where('bookings.user_id', Auth::User()->client->user_id)
        ->where('bookings.booking_id', $id)
        ->first();
        
        return response()->json(['payment' => $data]);
    }

    public function showBengkelPayment()
    {
        
        $data = DB::table('bookings')
        ->select('payments.*','bookings.repairment_date', 'booking_details.service_cost', 'booking_details.repairment_note','booking_details.bengkel_note', 'users.full_name', 'services.service_name')
        ->join('payments', 'payments.booking_id', 'bookings.booking_id')
        ->join('users', 'bookings.user_id', 'users.user_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('services', 'booking_details.service_id', 'services.service_id')
        ->where('bookings.bengkel_id', Auth::User()->bengkel->bengkel_id)
        ->orderBy('payments.status', 'desc')
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

    public function updateReceipt(Request $request, $id)
    {
        $booking = Booking::where('booking_id', $id)->where('user_id', Auth::User()->client->user_id)->first();
        $payment = $booking->payment;

        if($request->receipt != null){
            $validator = Validator::make($request->all(), [
                'receipt' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()]);
            }
            $file = $request->file('receipt');
            $path = 'upload\\receipt\\' . basename( $_FILES['receipt']['name']);
            move_uploaded_file($_FILES['receipt']['tmp_name'], $path);
            if($payment->receipt != null)
                File::delete($payment->receipt);   
            $payment->receipt = $path;
            $payment->status = "pending";
        }
        if($payment->save())
            return response()->json(['message' => 'Uploaded Successfully']);
    }
}
