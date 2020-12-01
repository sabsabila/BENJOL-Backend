<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class PickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['pickups' => Pickup::all()]);
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
        $pickup = new Pickup;
        $pickup->pickup_location = $request->pickup_location;
        $pickup->dropoff_location = $request->dropoff_location;
        //$pickup->status = $request->status;
        if($pickup->save()){
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = auth('api')->account()->user;
        $booking = $user->booking->sortByDesc('booking_id')->first();

        if($booking != null){
            $pickup = Pickup::find($booking->pickup_id);
        }else{
            $pickup = null;
        }
        return response()->json([ 'pickup' => $pickup]);
    }

    public function showMyPickups(){
        $bengkel = auth('api')->account()->bengkel;
        $booking = DB::table('pickups')
        ->select('bookings.booking_id','bookings.repairment_date', 'users.user_id', 'users.first_name', 'users.last_name', 'pickups.pickup_location', 'pickups.dropoff_location', 'pickups.status')
        ->join('bookings', 'bookings.pickup_id', 'pickups.pickup_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('users', 'bookings.user_id', 'users.user_id')
        ->join('services', 'booking_details.service_id', 'services.service_id')
        ->where('bookings.bengkel_id', $bengkel->bengkel_id )
        ->orderBy('bookings.repairment_date', 'asc')
        ->get();

        return response()->json(['pickups' => $booking]);
    }

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
        $pickup = Pickup::where('pickup_id', $booking->pickup_id)->first();
        $pickup->status = $request->status;
        if($pickup->save()){
            return response()->json([ 'message' => "Data Successfully Updated"]);
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
        $pickup = Pickup::find($id);
        if($pickup->delete()){
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }
    }
}
