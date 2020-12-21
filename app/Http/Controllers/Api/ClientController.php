<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use File;
use Hash;

class ClientController extends Controller
{
    public function show()
    {
        $data = DB::table('users')
        ->select('users.*','accounts.username', 'accounts.email', 'accounts.profile_picture', 'accounts.phone_number')
        ->join('accounts', 'users.account_id', 'accounts.id')
        ->where('accounts.id', Auth::User()->id)
        ->first();

        return response()->json(['user' => $data]);
    }

    public function seeUser($id)
    {
        $data = DB::table('users')
        ->select('users.first_name', 'users.last_name','accounts.phone_number', 'accounts.profile_picture')
        ->join('accounts', 'users.account_id', 'accounts.id')
        ->join('bookings', 'users.user_id', 'bookings.user_id')
        ->where('bookings.booking_id', $id)
        ->first();

        return response()->json(['user' => $data]);
    }

    public function update(Request $request)
    {
        $user = Auth::User();
        $client = $user->client;
        
        if($request->first_name != null)
            $client->first_name = $request->first_name;
        
        if($request->last_name != null)
            $client->last_name = $request->last_name;

        if($request->gender != null)
            $client->gender = $request->gender;

        if($request->birth_date != null)
            $client->birth_date = $request->birth_date;
        
        if($request->email != null)
            $user->email = $request->email;

        if($request->username != null)
            $user->username = $request->username;

        if($request->phone_number != null)
            $user->phone_number = $request->phone_number;

        if($request->newPassword != null){
            if(Hash::check($request->oldPassword, $user->password)){
                $user->password = app('hash')->make($request->newPassword);
            }else{
                return response()->json(["message" => "Old password doesn't match"], 401);
            }
        }
        
        $user->save();
        $client->save();
        return response()->json([ 'message' => "Data updated successfully"]);
    }

    public function upload(Request $request){
        $user = Auth::User();
        if($request->profile_picture != null){
            $validator = Validator::make($request->all(), [
                'profile_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                return response()->json(['message' => $validator->errors()->toJson()]);
            }
            $file = $request->file('profile_picture');
            $path = 'upload\\user\\' . basename( $_FILES['profile_picture']['name']);
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $path);
            if($user->profile_picture != null)
                File::delete($user->profile_picture);   
            $user->profile_picture = $path;
        }
        if($user->save())
            return response()->json(['message' => 'Uploaded Successfully']);
    }
}
