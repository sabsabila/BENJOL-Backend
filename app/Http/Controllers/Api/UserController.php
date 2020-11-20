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

        return "data added successfully";
    }

    public function update(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $gender = $request->gender;
        $birth_date = $request->birth_date;
        $user = auth('api')->account()->user;
        
        if($request->first_name != null)
            $user->first_name = $request->first_name;
        
        if($request->last_name != null)
            $user->last_name = $request->last_name;

        if($request->gender != null)
            $user->gender = $request->gender;

        if($request->birth_date != null)
            $user->birth_date = $request->birth_date;

        $user->save();
        return "data updated successfully";
    }

    public function destroy(){
        $user = User::where('account_id', auth('api')->account()->id)->delete();
        //$user->delete();

        return "data deleted successfully";
    }
}
