<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Bengkel;
use App\Models\User;
use App\Models\Motorcycle;
use App\Models\Pickup;

class BookingController extends Controller
{
    private BookingDetailController $bookingDetailController;
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
        $booking->bengkel_id =$request->bengkel_id;
        $booking->user_id =$request->user_id;
        $booking->motorcycle_id =$request->motorcycle_id;
        $booking->pickup_id =$request->pickup_id;
        $booking->repairment_type = $request->repairment_type;
        $booking->repairment_date = $request->repairment_date;
        $booking->repairment_note = $request->repairment_note;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        if ($booking->save()){
            $bookingDetail = $bookingDetailController->store($booking->booking_id,$request->service_id);
            return " Data Successfully Added ";
        }
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
        $booking = Booking::find($id);
        $booking->bengkel_id =$request->bengkel_id;
        $booking->user_id =$request->user_id;
        $booking->motorcycle_id =$request->motorcycle_id;
        $booking->pickup_id =$request->pickup_id;
        $booking->repairment_type = $request->repairment_type;
        $booking->repairment_date = $request->repairment_date;
        $booking->repairment_note = $request->repairment_note;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        if ($booking->save()){
            return " Data Successfully Updated ";
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
        $booking = Booking::find($id);
        if ($booking->delete()){
            return "Booking with id " . (int) $id . " successfully deleted ";
        }
    }
}