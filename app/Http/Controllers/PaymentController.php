<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        return Payment::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $payment = new Payment;
        $payment->booking_id = $request->booking_id;

        if ($payment->save()) {
            echo "Data Successfully Added";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function showMyPayment()
    {
        $data = DB::table('bookings')
        ->select('payments.*','bookings.repairment_date', 'bookings.repairment_type', 'booking_details.service_cost', 'booking_details.bengkel_note')
        ->join('payments', 'payments.booking_id', 'bookings.booking_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->where('bookings.user_id', auth('api')->account()->user->user_id)
        ->sortByDesc('booking_id')
        ->first();
        
        return response()->json([$data]);
    }

    public function showBengkelPayment()
    {
        $bookings = auth('api')->account()->bengkel->booking;
        $data = array();
        foreach($bookings as $booking){
            $data = $booking->payment;
        }
        return $data;
    }

    public function show($id){
        return Payment::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::find($id);

        $payment->status = $request->status;
        
        if ($payment->save()) {
            echo "Data Successfully Updated";
        }
    }

    public function updateReceipt(Request $request)
    {
        $booking = auth('api')->account()->user->booking->sortByDesc('booking_id')->first();
        $payment = $booking->payment;
        $payment->receipt = $request->receipt;
        
        if ($payment->save()) {
            echo "Data Successfully Updated";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment->delete()) {
            echo "Payment with id " . (int) $id . " successfully deleted";
        }
    }
}
