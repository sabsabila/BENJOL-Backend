<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{

    public function bengkel()
    {
        return $this->belongsTo('App\Models\Bengkel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sparepart::all();
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
        $sparepart = new Sparepart();
        $sparepart->bengkel_id = $request->bengkel_id;
        $sparepart->price = $request->price;
        $sparepart->stock = $request->stock;

        if ($payment->save()) {
            echo "Data Successfully Added";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Sparepart::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function edit(Sparepart $sparepart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $sparepart = Sparepart::find($id);

        if ($request->bengkel_id != null)
            $sparepart->bengkel_id = $request->bengkel_id;

        if ($request->sparepart_name != null)
            $sparepart->sparepart_name = $request->sparepart_name;


        if ($request->price != null)
            $sparepart->price = $request->price;

        if ($request->stock != null)
            $sparepart->stock = $request->stock;
        
        if ($sparepart->save()) {
            echo "Data Successfully Updated";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sparepart $sparepart)
    {
        $sparepart = Sparepart::find($id);

        if ($sparepart->delete()) {
            echo "Sparepart with id " . (int) $id . " successfully deleted";
        }
    }
}
