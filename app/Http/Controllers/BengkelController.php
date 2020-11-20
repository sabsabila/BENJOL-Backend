<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;
use Illuminate\Support\Facades\DB;

class BengkelController extends Controller
{
    public function index() {
        $bengkels = DB::table('bengkels')
        ->select('bengkels.*','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')->get();

        return response()->json(['bengkels' => $bengkels]);
    }

    public function store(Request $request) {
        $bengkel = new Bengkel;
        $bengkel->account_id = $request->account_id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;

        if ($bengkel->save()) {
            echo "Data Successfully Added";
        }
    }

    public function findByName(Request $request){
        $name = $request->name;
        $bengkels = DB::table('bengkels')
        ->select('bengkels.*','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')
        ->where('bengkels.name', 'like', "%{$name}%")->get();

        return response()->json(['bengkels' => $bengkels]);
    }

    public function show()
    {
        $bengkel = auth('api')->account()->bengkel;

        return response()->json(['bengkel' => $bengkel]);
    }

    public function update(Request $request) {
        $bengkel = auth('api')->account()->bengkel;

        if ($request->account_id != null)
            $bengkel->account_id = $request->account_id;
        
        if ($request->name != null)
            $bengkel->name = $request->name;

        if ($request->address != null)
            $bengkel->address = $request->address;
        
        if ($bengkel->save()) {
            echo "Data Successfully Updated";
        }
    }

    public function delete() {
        $bengkel = auth('api')->account()->bengkel;
        
        if ($bengkel->delete()) {
            echo "successfully deleted";
        }
    }
}
