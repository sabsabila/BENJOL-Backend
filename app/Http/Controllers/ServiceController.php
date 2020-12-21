<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\BookingDetail;
Use App\Models\Bengkel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    
    public function store(Request $request)
    {
        $service = new Service;
        $service->bengkel_id = Auth::User()->bengkel->bengkel_id;
        $service->service_name = $request->service_name;

        if($service->save()){
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }

    public function show($bengkelId)
    {
        $bengkel = Bengkel::find($bengkelId);
        $services = $bengkel->service;
        
        return response()->json(['services' => $services]);
    }

    public function myServices()
    {
        $bengkel = Auth::User()->bengkel;
        $services = $bengkel->service;
        
        return response()->json(['services' => $services]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::where('service_id', $id)
        ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)
        ->first();

        $service->service_name = $request->service_name;
        if($service->save()){
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }

    public function destroy($id)
    {
        $service= Service::where('service_id', $id)
        ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)
        ->first();
        
        if($service->delete()){
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }
    }
}
