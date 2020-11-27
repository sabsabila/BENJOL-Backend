<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BookingDetail;
use App\Models\Bengkel;
use App\Models\User;
use App\Models\Motorcycle;
use App\Models\Pickup;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    private $bookingDetailController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo Booking::all();
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

    public function show($id)
    {
        return Booking::find($id);
    }

    public function userBooking(){
        $user = auth('api')->account()->user;
        $booking = DB::table('bookings')
        ->select('bookings.repairment_date','booking_details.repairment_note', 'bengkels.name')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('bengkels', 'bookings.bengkel_id', 'bengkels.bengkel_id')
        ->where('bookings.bengkel_id', $user->user_id )
        ->first();
        return response()->json(['booking' => $booking]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking();
        $bookingDetailController = new BookingDetailController();
      
        $booking->user_id = auth('api')->account()->user->user_id;
        $motorcycle_id = $request->motorcycle_id;  
        $booking->motorcycle_id = $motorcycle_id;

        $isPickup = $request->isPickup;
        if($isPickup == "Yes"){
            $pickup = new Pickup();
            $pickup->pickup_location = $request->pickup_location;
            $pickup->dropoff_location = $request->dropoff_location;
            $pickup->save();
            $booking->pickup_id = $pickup->pickup_id;
        }else{
            $booking->pickup_id = null;
        }

        $booking->bengkel_id = $request->bengkel_id;
        $booking->repairment_date = $request->repairment_date;

        if ($booking->save()){
            $payment = new Payment();
            $payment->booking_id = $booking->booking_id;
            $payment->save();
            $bookingDetail = $bookingDetailController->store(
                                $booking->booking_id,
                                $request->service_id,
                                $request->repairment_note);
            return response()->json([ 'message' => "Data Successfully Added"]);
        }else
            return response()->json([ 'message' => "Failed"]);
    }

    public function showMyBooking(){
        $bengkel = auth('api')->account()->bengkel;
        $booking = DB::table('bookings')
        ->select('bookings.*','booking_details.*')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->where('bookings.bengkel_id', $bengkel->bengkel_id )
        ->get();

        return response()->json(['booking' => $booking]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();
        
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        if ($booking->save()){
            return response()->json(['message' => " Data Successfully Updated"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();
        $bookingDetail = BookingDetail::where('booking_id', $booking->booking_id);
        Payment::where('booking_id', $booking->booking_id)->delete();
        $bookingDetail->delete();
        if ($booking->delete()){
            return response()->json(['message' => "Booking with id " . (int) $id . " successfully deleted "]);
        }
    }
}