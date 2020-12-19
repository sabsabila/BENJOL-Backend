<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Bengkel;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        
        if( Auth::attempt(['email'=>request('email'), 'password'=>request('password')]) ) {

            $user = Auth::User();
            
            if($user->bengkel != null)
                $userRole = 'bengkel';
            else
                $userRole = 'user';

            if ($userRole) {
                $this->scope = $userRole;
            }

            $token = $user->createToken($user->email.'-'.now(), [$this->scope]);

            return response()->json([
                'token' => $token->accessToken
            ]);

        }else{
            return response()->json([
                'message' => "Wrong e-mail or password",
            ], 401);
        }
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['username'] =  $user->username;
        $client = new Client;
        $client->account_id = $user->id;
        $client->first_name = $request->firstName;
        $client->last_name = $request->lastName;
        $client->save();
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
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['username'] =  $user->username;
        $bengkel = new Bengkel;
        $bengkel->account_id = $user->id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;
        $bengkel->save();

        return response()->json(['success'=>$success], $this->successStatus);
    }

    
    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        if($logout){
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        }
    }

}
