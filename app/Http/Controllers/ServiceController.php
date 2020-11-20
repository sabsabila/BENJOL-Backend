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
        $service->bengkel_id = auth('api')->account()->bengkel->bengkel_id;
        $service->service_name = $request->service_name;

        if($service->save()){
            echo "service data successfully added !";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bengkelId)
    {
        $bengkel = Bengkel::find($bengkelId);
        $services = $bengkel->service;
        
        return response()->json(['services' => $services]);
    }

    public function myServices()
    {
        $bengkel = auth('api')->account()->bengkel;
        $services = $bengkel->service;
        
        return response()->json(['services' => $services]);
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
        $service = Service::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();
        $service->service_name = $request->service_name;
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
        $service= Service::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();
        if($service->delete()){
            echo "service with id " .((int)$id). " has successfully removed.";
        }
    }
}
