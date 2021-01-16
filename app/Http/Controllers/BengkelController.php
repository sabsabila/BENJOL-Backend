<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $id = Auth::User()->bengkel->bengkel_id;
        $bengkel = DB::table('bengkels')
        ->select('bengkels.*', 'accounts.email', 'accounts.phone_number', 'accounts.profile_picture')
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
        $user = Auth::User();
        $bengkel = $user->bengkel;
      
        if ($request->name != null)
            $bengkel->name = $request->name;

        if ($request->address != null)
            $bengkel->address = $request->address;

        if ($request->email != null)
            $user->email = $request->email;

        if ($request->phone_number != null)
            $user->phone_number = $request->phone_number;

        if($request->newPassword != null){
            if(Hash::check($request->oldPassword, $user->password)){
                $user->password = app('hash')->make($request->newPassword);
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
            $path = 'upload/bengkel/' . basename( $_FILES['profile_picture']['name']);
            if($user->profile_picture != null)
                File::delete($user->profile_picture);   
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $path);
            $user->profile_picture = $path;
        }
        
        if ($bengkel->save() && $user->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }
}
