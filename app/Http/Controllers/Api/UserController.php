<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use App\Models\Account;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function create(Request $request){
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
        //$account = auth('api')->account();

        //$user = Account::find($account->id)->user;
        $user = User::where('account_id', auth('api')->account()->id)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'gender' => $gender,
            'birth_date' => $birth_date,
            ]);
        //User::where('account_id', auth('api')->account()->id)->firstOrFail();
        //$user->first_name = $first_name;
        //$user->last_name = $last_name;
        //$user->gender = $gender;
        //$user->birth_date = $birth_date;
        //$user->save();

        return "data updated successfully";
    }

    public function delete(){
        $user = User::where('account_id', auth('api')->account()->id)->delete();
        //$user->delete();

        return "data deleted successfully";
    }
}
