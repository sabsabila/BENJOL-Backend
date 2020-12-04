<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use File;

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

        return response()->json(['spareparts' => $spareparts]);
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

        return response()->json(['spareparts' => $spareparts]);
    }

    public function findByBengkel($id){
        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')
        ->where('spareparts.bengkel_id', $id)->get();
    
        return response()->json(['spareparts' => $spareparts]);
    }

    public function mySparepartList(){
        $bengkel = auth('api')->account()->bengkel;
        $result = $bengkel->sparepart;
        // $spareparts = DB::table('spareparts')
        // ->select('spareparts.sparepart_id', 'spareparts.name', 'spareparts.price', 'spareparts.stock')
        // ->where('spareparts.bengkel_id', $bengkel->bengkel_id)->get();

        return response()->json(['spareparts' => $result]);
    }

    public function searchInBengkel(Request $request, $id){
        $name = $request->name;
        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')
        ->where('spareparts.name', 'like', "%{$name}%")
        ->where('spareparts.bengkel_id', $id)->get();
        return response()->json(['spareparts' => $spareparts]);
    }

    public function findByNameInBengkel(Request $request){
        $bengkel = auth('api')->account()->bengkel;
        $name = $request->name;
        $result = Sparepart::where('name', 'like', "%{$name}%")
                ->where('bengkel_id', $bengkel->bengkel_id)->get();

        return response()->json(['spareparts' => $result]);
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
        if($request->picture != null){
            $validator = Validator::make($request->all(), [
                'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()]);
            }
            $file = $request->file('picture');
            $upload_dest = 'upload\\sparepart\\' . basename( $_FILES['picture']['name']);
            move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dest);
            
            $sparepart->picture = $upload_dest;
        }

        if ($sparepart->save()) {
            return response()->json([ 'message' => "Data Successfully Added"]);
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
        return response()->json(['spareparts' => Sparepart::find($id)]);
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
        $sparepart = Sparepart::where('sparepart_id', $id)
        ->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)
        ->first();

        if ($request->name != null)
            $sparepart->name = $request->name;

        if ($request->price != null)
            $sparepart->price = $request->price;

        if ($request->stock != null)
            $sparepart->stock = $request->stock;

        if($request->picture != null){
            $validator = Validator::make($request->all(), [
                'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()]);
            }
            $file = $request->file('picture');
            $upload_dest = 'upload\\sparepart\\' . basename( $_FILES['picture']['name']);
            move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dest);
            if($sparepart->picture != null)
                File::delete($sparepart->picture);   
            $sparepart->picture = $upload_dest;
        }
        
        if ($sparepart->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
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
        $sparepart = Sparepart::where('sparepart_id', $id)
        ->where('bengkel_id', auth('api')->account()->bengkel->bengkel_id)
        ->first();

        if ($sparepart->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }
    }
}
