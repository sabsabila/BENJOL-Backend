<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\App;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Service::all();
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = new Service;
        $booking_id = $request->booking_id;
        $service->service_name = $request->service_name;
        $service->cost = $request->cost;
        $bookingDetailController = new BookingDetailController();
        
        if($service->save()){
            echo "service data successfully added !";
            $bookingDetail = $bookingDetailController->store($booking_id,$service->service_id);
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
        $items = array();
        $bookingDetails = auth('api')->account()
                        ->user->booking->sortByDesc('booking_id')
                        ->first()->bookingDetail;

        foreach($bookingDetails as $detail) {
            $items[] = $detail->service;
        }

        return $items;
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
        $service = Service::find($id);
        $service->service_name = $request->service_name;
        $service->cost = $request->cost;
        if($service->save()){
            echo "service data successfully updated !";
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
        $service= Service::find($id);
        $bookingDetail = BookingDetail::where('booking_id', $id);
        $bookingDetail->delete();
        if($service->delete()){
            echo "service with id " .((int)$id). " has successfully removed.";
        }
    }
}
