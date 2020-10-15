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
        return Pickup::all();
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
        $pickup->status = $request->status;
        if($pickup->save()){
            echo "Your Pickup data has successfully saved!";
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
        return $pickup;
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
        $pickup->pickup_location = $request->pickup_location;
        $pickup->dropoff_location = $request->dropoff_location;
        $pickup->status = $request->status;
        if($pickup->save()){
            echo "Your Pickup data has successfully updated!";
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
            echo "Your Pickup data has successfully deleted!";
        }
    }
}
