<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'  => 'required|string',
            'email'  => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' =>bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' =>$user,
            'token'=>$token
        ];

        return response($response, 201);

    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'  => 'required|email',
            'password' => 'required|string'
        ]);

       $user = User::where('email',$fields['email'])->first();

       if(!$user || !Hash::check($fields['password'], $user->password)){
           return response([
               'message' =>'Credentials not match'
           ],401);
       }


        $token = $user->createToken('api_token')->plainTextToken;

        $response = [
            'user' =>$user,
            'token'=>$token
        ];

        return response($response, 201);

    }

        public function logout(){
        auth()->user()->tokens()->delete();

        return [
            'message' =>'You have successfully logged out and the token was successfully deleted'
        ];

    }




}
