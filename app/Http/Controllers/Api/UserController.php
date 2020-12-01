<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use App\Models\Account;

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
        ->get();

        return response()->json(['users' => $data]);
    }

    public function seeUser($id)
    {
        $data = DB::table('users')
        ->select('users.first_name', 'users.last_name','accounts.phone_number')
        ->join('accounts', 'users.account_id', 'accounts.id')
        ->where('users.user_id', $id)
        ->get();

        return response()->json(['users' => $data]);
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
