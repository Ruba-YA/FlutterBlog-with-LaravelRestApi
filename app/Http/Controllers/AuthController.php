<?php

namespace App\Http\Controllers;
use Laravel\Sanctum\HasApiTokens;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        // Validate fields

        $attributes = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:3'
        ]);

        //create user
        $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);

        //return user and token in response

        return response([
            'user'=>$user,
            'token' =>$user->createToken('secret')->plainTextToken
        ],200);

    }

    public Function  login(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        //attemp login
        if (!Auth::attempt($attributes)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }
      
        // If login is successful, return user and token in the response
         $user = auth()->user();
        $token = $user->createToken('secret')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }


        public function logout()
        {
            auth()->user()->User::tokens()->delete();
            return response([
                'message' =>'Logout Success'
            ],200);
        }

        public function showuser()
        {
            return response([
                'user' =>auth()->user()
            ],200);
        }

        public function update(Request $request)
        {
            $attributes = $request->validate([
                'name' => 'required|string',
            ]);
            $image = $this->saveImage($request->image , 'profiles');

            auth()->user()->update([
                'name' => $attributes['name'],
                'image' => $image
            ]);

            return response([
                'user' =>auth()->user(),
                'message' =>'Updated Success'
            ],200);
           
            
        }

}

