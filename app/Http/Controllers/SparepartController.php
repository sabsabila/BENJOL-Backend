<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')->get();

        return response()->json(['spareparts' => $spareparts]);
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

    public function bengkelSparepartList(){
        $bengkel = Auth::User()->bengkel;
        $result = $bengkel->sparepart;
        return response()->json(['spareparts' => $result]);
    }

    public function searchPerBengkel(Request $request, $id){
        $name = $request->name;
        $spareparts = DB::table('spareparts')
        ->select('spareparts.*','bengkels.name as bengkel', 'bengkels.address')
        ->join('bengkels', 'spareparts.bengkel_id', 'bengkels.bengkel_id')
        ->where('spareparts.name', 'like', "%{$name}%")
        ->where('spareparts.bengkel_id', $id)->get();
        return response()->json(['spareparts' => $spareparts]);
    }

    public function searchInBengkel(Request $request){
        $bengkel = Auth::User()->bengkel;
        $name = $request->name;
        $result = Sparepart::where('name', 'like', "%{$name}%")
                ->where('bengkel_id', $bengkel->bengkel_id)->get();

        return response()->json(['spareparts' => $result]);
    }

    public function store(Request $request)
    {
        $sparepart = new Sparepart();
        $bengkel = Auth::User()->bengkel;
        
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
            $upload_dest = 'upload/sparepart/' . basename( $_FILES['picture']['name']);
            move_uploaded_file($_FILES['picture']['tmp_name'], $upload_dest);
            
            $sparepart->picture = $upload_dest;
        }

        if ($sparepart->save()) {
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }

    public function show($id)
    {
        return response()->json(['spareparts' => Sparepart::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::where('sparepart_id', $id)
        ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)
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

    public function destroy($id)
    {
        $sparepart = Sparepart::where('sparepart_id', $id)
        ->where('bengkel_id', Auth::User()->bengkel->bengkel_id)
        ->first();
        if($sparepart->picture != null)
            File::delete($sparepart->picture); 
        if ($sparepart->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }
    }
}
