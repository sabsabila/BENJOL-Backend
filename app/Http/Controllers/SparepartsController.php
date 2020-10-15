<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sparepart = Sparepart::all();
        $data = ['sparepart'=>$sparepart];

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $sparepart->created_at = $request->created_at;
        $sparepart->updated_at = $request->updated_at;
        $sparepart->save();

        return "Sparepart Saved!";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function show(Sparepart $sparepart)
    {
        $sparepart = Sparepart::find($id);

        return $sparepart;
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
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::find($id);
        $sparepart->bengkel_id = $request->bengkel_id;
        $sparepart->price = $request->price;
        $sparepart->stock = $request->stock;
        $sparepart->save();

        return "Sparepart Updated!";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sparepart = Sparepart::find($id);
        $sparepart->delete();

        return "Sparepart Deleted";
    }
}