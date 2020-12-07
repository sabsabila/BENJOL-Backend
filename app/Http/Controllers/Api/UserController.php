<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use File;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function create()
    {
        
    }

    public function show()
    {
        $data = DB::table('users')
        ->select('users.*','accounts.username', 'accounts.email', 'accounts.profile_picture', 'accounts.phone_number')
        ->join('accounts', 'users.account_id', 'accounts.id')
        ->where('accounts.id', auth('api')->account()->id)
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

    public function edit($id)
    {
        //
    }

    public function store(Request $request){
        $user = new User;
        $account = auth('api')->account();

        $user->account_id = $account->id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        $user->save();

        return response()->json([ 'message' => "Data added successfully"]);
    }

    public function update(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $gender = $request->gender;
        $birth_date = $request->birth_date;
        $email = $request->email;
        $username = $request->username;
        $phone_number = $request->phone_number;
        $account = auth('api')->account();
        $user = $account->user;
        
        if($first_name != null)
            $user->first_name = $first_name;
        
        if($last_name != null)
            $user->last_name = $last_name;

        if($gender != null)
            $user->gender = $gender;

        if($birth_date != null)
            $user->birth_date = $birth_date;
        
        if($email != null)
            $account->email = $email;

        if($username != null)
            $account->username = $username;

        if($phone_number != null)
            $account->phone_number = $phone_number;
        
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
            if($account->profile_picture != null)
                File::delete($account->profile_picture);   
            $account->profile_picture = $path;
        }

        $account->save();
        $user->save();
        return response()->json([ 'message' => "Data updated successfully"]);
    }

    public function destroy(){
        $user = User::where('account_id', auth('api')->account()->id)->delete();
        //$user->delete();

        return response()->json([ 'message' =>  "Data deleted successfully"]);
    }
}
