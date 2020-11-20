<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;

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
    public function show($id)
    {
        $pickup = Pickup::find($id);
        return response()->json([ 'pickup' => $pickup]);
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
        $pickup = Pickup::find($id);
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
