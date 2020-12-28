<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PickupController extends Controller
{
    public function show($id)
    {
        $client = Auth::User()->client;
        $booking = Booking::where('booking_id', $id)->where('user_id', $client->user_id)->first();

        if($booking != null){
            $pickup = Pickup::find($booking->pickup_id);
        }else{
            $pickup = null;
        }
        return response()->json([ 'pickup' => $pickup]);
    }

    public function showAll()
    {
        $client = Auth::User()->client;
        $pickups = DB::table('pickups')
        ->select('bookings.booking_id','bookings.repairment_date','bengkels.name', 'pickups.pickup_location', 'pickups.dropoff_location')
        ->join('bookings', 'bookings.pickup_id', 'pickups.pickup_id')
        ->join('bengkels', 'bookings.bengkel_id', 'bengkels.bengkel_id')
        ->where('bookings.user_id', $client->user_id)
        ->orderBy('bookings.repairment_date', 'desc')
        ->orderBy('pickups.pickup_id', 'desc')
        ->get();

        return response()->json([ 'pickups' => $pickups]);
    }

    public function showBengkelPickups(){
        $bengkel = Auth::User()->bengkel;
        $booking = DB::table('pickups')
        ->select('bookings.booking_id','bookings.repairment_date', 'users.user_id', 'users.full_name', 'pickups.pickup_location', 'pickups.dropoff_location', 'pickups.status')
        ->join('bookings', 'bookings.pickup_id', 'pickups.pickup_id')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('users', 'bookings.user_id', 'users.user_id')
        ->join('services', 'booking_details.service_id', 'services.service_id')
        ->where('bookings.bengkel_id', $bengkel->bengkel_id )
        ->orderBy('bookings.repairment_date', 'asc')
        ->orderBy('pickups.pickup_id', 'desc')
        ->get();

        return response()->json(['pickups' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('booking_id', $id)
        ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)->first();
        $pickup = Pickup::where('pickup_id', $booking->pickup_id)->first();
        $pickup->status = $request->status;
        if($pickup->save()){
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }
}
