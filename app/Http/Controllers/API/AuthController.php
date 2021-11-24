<?php

namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
   
class AuthController extends BaseController
{

    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 
            $token['token'] =  $authUser->createToken('access_token')->plainTextToken; 
            $token['id'] =  $authUser->id;
   
            return $this->sendResponse('User signed in', $token, 201);
        } 
        else{ 
            return $this->sendError('Unauthorised.', [], 401);
        } 
    }

    public function signup(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Invalid parameter/s.', [], 400);       
        }
        
        $input = $request->only('email', 'password');
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
   
        if($user) {
            return $this->sendResponse('User successfully registered.', [], 201);
        }

        return $this->sendResponse('User failed registering.', [$input], 401);
    }

    public function checkEmail(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users',
        ]);

        if($validator->fails()){
            return $this->sendError('Email already taken.', [], 400);       
        }
    }
   
}
