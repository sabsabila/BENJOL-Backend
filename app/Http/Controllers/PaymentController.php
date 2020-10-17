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

    public function show($id)
    {
        return Payment::find($id);
    }

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

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment->delete()) {
            echo "Payment with id " . (int) $id . " successfully deleted";
        }
    }
}
