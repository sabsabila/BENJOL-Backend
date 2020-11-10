<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparepartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')->get();

        return $spareparts;
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

    public function findByName(Request $request){
        $name = $request->name;

        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')
        ->where('spareparts.name', 'like', "%{$name}%")->get();

        return $spareparts;
    }

    public function findByBengkel($id){
        $bengkel = Bengkel::find($id);
        $result = $bengkel->sparepart;

        return $result;
    }

    public function mySparepartList(){
        $bengkel = auth('api')->account()->bengkel;
        $result = $bengkel->sparepart;

        return $result;
    }

    public function findByNameInBengkel(Request $request){
        $bengkel = auth('api')->account()->bengkel;
        $name = $request->name;
        $result = Sparepart::where('name', 'like', "%{$name}%")
                ->where('bengkel_id', $bengkel->bengkel_id)->get();

        return $result;
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
        $bengkel = auth('api')->account()->bengkel;
        
        $sparepart->bengkel_id = $bengkel->bengkel_id;
        $sparepart->name = $request->name;
        $sparepart->price = $request->price;
        $sparepart->stock = $request->stock;

        if ($sparepart->save()) {
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
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();

        if ($request->name != null)
            $sparepart->name = $request->name;

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
    public function destroy($id)
    {
        $sparepart = Sparepart::find($id)->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)->first();

        if ($sparepart->delete()) {
            echo "Sparepart with id " . (int) $id . " successfully deleted";
        }
    }
}
