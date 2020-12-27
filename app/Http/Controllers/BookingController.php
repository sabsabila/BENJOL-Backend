<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\BookingDetail;
use App\Models\Bengkel;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\Pickup;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private $bookingDetailController;
    
    public function userBooking(){
        $client = Auth::User()->client;
        $booking = DB::table('bookings')
        ->select('bookings.booking_id','bookings.repairment_date','booking_details.repairment_note', 'bookings.status', 'bengkels.name')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('bengkels', 'bookings.bengkel_id', 'bengkels.bengkel_id')
        ->where('bookings.user_id', $client->user_id )
        ->orderBy('bookings.booking_id', 'desc')
        ->first();
        return response()->json(['booking' => $booking]);
    }

    public function userBookingAll(){
        $client = Auth::User()->client;
        $booking = DB::table('bookings')
        ->select('bookings.booking_id','bookings.repairment_date','bookings.status', 'booking_details.repairment_note', 'bengkels.name')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('bengkels', 'bookings.bengkel_id', 'bengkels.bengkel_id')
        ->where('bookings.user_id', $client->user_id )
        ->orderBy('bookings.booking_id', 'desc')
        ->get();
        return response()->json(['bookings' => $booking]);
    }

    public function store(Request $request)
    {
        $booking = new Booking();
        $bookingDetailController = new BookingDetailController();
      
        $booking->user_id = Auth::User()->client->user_id;
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

    public function showBengkelBooking(){
        $bengkel = Auth::User()->bengkel;
        $booking = DB::table('bookings')
        ->select('bookings.booking_id','bookings.repairment_date','bookings.start_time', 'bookings.end_time', 'bookings.status', 'booking_details.repairment_note', 'users.user_id', 'users.full_name','services.service_name')
        ->join('booking_details', 'bookings.booking_id', 'booking_details.booking_id')
        ->join('users', 'bookings.user_id', 'users.user_id')
        ->join('services', 'booking_details.service_id', 'services.service_id')
        ->where('bookings.bengkel_id', $bengkel->bengkel_id )
        ->orderBy('bookings.status', 'desc')
        ->orderBy('bookings.repairment_date', 'asc')
        ->get();

        return response()->json(['booking' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('booking_id',$id)
                    ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)->first();
        
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->status = "ongoing";
        if ($booking->save()){
            return response()->json(['message' => " Data Successfully Updated"]);
        }
    }

    public function setBookingStatus(Request $request, $id)
    {
        $booking = Booking::where('booking_id',$id)
                    ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)->first();
        
        $booking->status = $request->status;
        if ($booking->save()){
            return response()->json(['message' => " Data Successfully Updated"]);
        }
    }

    public function bookingCount(Request $request){
        $status = $request->status;
        $count = DB::table('bookings')
                ->select(DB::raw('count(*) as booking_count'))
                ->where('bengkel_id',Auth::User()->bengkel->bengkel_id)
                ->where('bookings.status', $status)
                ->groupBy('bengkel_id')
                ->first();
        return response()->json(['count' => $count]);
    }

    public function destroy($id)
    {
        $booking = Booking::where('bengkel_id', Auth::User()->bengkel->bengkel_id)
                    ->where('booking_id', $id)->first();
        $bookingDetail = BookingDetail::where('booking_id', $booking->booking_id);
        $pickup_id = $booking->pickup_id;
        Payment::where('booking_id', $booking->booking_id)->delete();
        $bookingDetail->delete();
        if ($booking->delete()){
            Pickup::where('pickup_id', $pickup_id)->delete();
            return response()->json(['message' => "Data successfully deleted "]);
        }
    }
}