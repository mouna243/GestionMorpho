<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    // register
    public function register(Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'telephon' => 'required|string|min:10|max:20',
            'CIN' => 'required|string|unique:users',
            'age' => 'required|integer|min:18|max:100'

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephon' => $request->telephon,
            'CIN' => $request->CIN,
            'age' => $request->age
        ]);

        //201 : created successfully
        if($user){
            return response()->json(
                [
                    "success" => true,
                    'message' => 'user created successfully'
                ]
                ,
                201
            );
        }

        return response()->json(
            [
                "success" => false,
                'message' => 'register failed'
            ],
            401
        );
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {

            // 401 : Unauthorized request
            return response()->json([
                    "success" => false,
                    'message' => 'Invalid credentials'
                    ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // 200 : success
        return response()->json(
            [
                "success" => true,
                'token' => $token,
                'message' => 'user logged in successfully'
            ]
            ,
            200
        );
    }

    public function logout()
    {
        Auth::logout();
        // 200 : success
        return response()->json([
            'message' => 'user logged out successfully'
        ], 200);
    }

    public function me(){
        return response()->json(
            [
                'user' => Auth::user(),
                'message' => 'user logged in successfully'
            ]
            ,
            200
        );
    }
}
