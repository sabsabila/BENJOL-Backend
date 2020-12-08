<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;
use Illuminate\Support\Facades\DB;
use Validator;
use File;
use Hash;

class BengkelController extends Controller
{
    public function index() {
        $bengkels = DB::table('bengkels')
        ->select('bengkels.*','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')->get();

        return response()->json(['bengkel' => $bengkels]);
    }

    public function store(Request $request) {
        $bengkel = new Bengkel;
        $bengkel->account_id = $request->account_id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;

        if ($bengkel->save()) {
            return response()->json([ 'message' => "Data Successfully Added"]);
        }
    }

    public function findByName(Request $request){
        $name = $request->name;
        $bengkels = DB::table('bengkels')
        ->select('bengkels.*','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')
        ->where('bengkels.name', 'like', "%{$name}%")->get();

        return response()->json(['bengkel' => $bengkels]);
    }

    public function show()
    {
        $id = auth('api')->account()->bengkel->bengkel_id;
        $bengkel = DB::table('bengkels')
        ->select('bengkels.*','accounts.username', 'accounts.email', 'accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')
        ->where('bengkels.bengkel_id', $id)->first();

        return response()->json(['bengkel' => $bengkel]);
    }

    public function getBengkel($id)
    {
        $bengkel = DB::table('bengkels')
        ->select('bengkels.*','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'bengkels.account_id', 'accounts.id')
        ->where('bengkels.bengkel_id', $id)->get();

        return response()->json(['bengkel' => $bengkel]);
    }

    public function update(Request $request) {
        $account = auth('api')->account();
        $bengkel = $account->bengkel;
      
        if ($request->name != null)
            $bengkel->name = $request->name;

        if ($request->address != null)
            $bengkel->address = $request->address;

        if ($request->username != null)
            $account->username = $request->username;

        if ($request->email != null)
            $account->email = $request->email;

        if ($request->phone_number != null)
            $account->phone_number = $request->phone_number;

        if($request->newPassword != null){
            if(Hash::check($request->oldPassword, $account->password)){
                $account->password = app('hash')->make($request->newPassword);
            }else{
                return response()->json(["message" => "Old password doesn't match"], 401);
            }
        }

        if($request->profile_picture != null){
            $validator = Validator::make($request->all(), [
                'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()]);
            }
            $file = $request->file('profile_picture');
            $path = 'upload\\bengkel\\' . basename( $_FILES['profile_picture']['name']);
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $path);
            if($account->profile_picture != null)
                File::delete($account->profile_picture);   
            $account->profile_picture = $path;
        }
        
        if ($bengkel->save() && $account->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }

    public function delete() {
        $bengkel = auth('api')->account()->bengkel;
        
        if ($bengkel->delete()) {
            return response()->json([ 'message' => "successfully deleted"]);
        }
    }
}
