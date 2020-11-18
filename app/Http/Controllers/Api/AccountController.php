<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Models\Bengkel;
use Illuminate\Support\Facades\Auth;
use Validator;

class AccountController extends Controller
{
    public $successStatus = 200;

    public function index(){
        return Account::all();
    }

    public function login()
    {
        
        if( Auth::attempt(['email'=>request('email'), 'password'=>request('password')]) ) {

            $account = Auth::Account();
            //$userRole = $user->role()->first();
            
            if($account->bengkel != null)
                $userRole = 'bengkel';
            else
                $userRole = 'user';

            if ($userRole) {
                $this->scope = $userRole;
            }

            $token = $account->createToken($account->email.'-'.now(), [$this->scope]);

            echo $userRole;

            return response()->json([
                'token' => $token->accessToken
            ]);

        }else{
            return "Wrong email or password !";
        }
    }

    public function registerUser(Request $request)
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
        $user = new User;
        $user->account_id = $account->id;
        $user->save();
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function registerBengkel(Request $request)
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
        $bengkel = new Bengkel;
        $bengkel->account_id = $account->id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;
        $bengkel->save();

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function update(Request $request)
    {
        $account = Auth::account();

        if($request->username != null)
            $account->username = $request->username;
        
        if($request->password != null)
            $account->password = $request->password;

        if($request->email != null)
            $account->email = $request->email;

        if($request->phone_number != null)
            $account->phone_number = $request->phone_number;

        if($request->profile_picture != null)
            $account->profile_picture = $request->profile_picture;

        $account->save();
        return "data updated successfully";
    }

    public function destroy(){
        $account = Auth::account();
        if($account->user != null){
            $account->user->delete();
        }else{
            $account->bengkel->delete();
        }$account->delete();

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
