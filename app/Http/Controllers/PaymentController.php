<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $payment->total_price = $request->total_price;
        $payment->receipt = $request->receipt;

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
        $booking = auth('api')->account()->user->booking->first();
        return $booking->payment;
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
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if ($request->booking_id != null)
            $payment->booking_id = $request->booking_id;

        if ($request->total_price != null)
            $payment->total_price = $request->total_price;

        if ($request->receipt != null)
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
