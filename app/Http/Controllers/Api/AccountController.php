<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Validator;

class AccountController extends Controller
{
    public $successStatus = 200;

    public function index(){
        return Account::all();
    }

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $account = Auth::account();
            $success['token'] =  $account->createToken('nApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $account = Account::create($input);
        $success['token'] =  $account->createToken('nApp')->accessToken;
        $success['username'] =  $account->username;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function update(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $email = $request->email;
        $phone_number = $request->phone_number;

        $account = Auth::account();
        $account->username = $username;
        $account->password = $password;
        $account->email = $email;
        $account->phone_number = $phone_number;
        $account->save();

        return "data updated successfully";
    }

    public function delete(){
        $account = Auth::account();
        $account->delete();

        return "data deleted successfully";
    }

    public function logout(Request $request)
    {
        $logout = $request->account()->token()->revoke();
        if($logout){
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
    }

    public function details()
    {
        $account = Auth::account();
        return response()->json(['success' => $account], $this->successStatus);
    }
}
