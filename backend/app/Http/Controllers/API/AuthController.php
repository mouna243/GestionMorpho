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

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $role = $request->role;
        $departement_id = $request->departement_id;
        $salaire = $request->salaire;
        $experience = $request->experience;
        $langage = $request->langage;
        $telephon = $request->telephon;
        $CIN = $request->CIN;
        $age = $request->age;

        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => 'required|string|in:client,admin,staff',
            'departement_id' => 'required|integer',
            'salaire' => 'required|numeric',
            'experience' => 'required|string',
            'langage' => 'required|string',
            'telephon' => 'required|string|min:10|max:20',
            'CIN' => 'required|string|unique:users',
            'age' => 'required|integer|min:18|max:100'

        ]);

        $user = User::create([

            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'departement_id' => $departement_id,
            'salaire' => $salaire,
            'experience' => $experience,
            'langage' => $langage,
            'telephon' => $telephon,
            'CIN' => $CIN,
            'age' => $age
        ]);
        //201 : created successfully
        return response()->json(
            [
                'user' => $user,
                'message' => 'user created successfully'
            ]
            ,
            201
        );
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {

            // 401 : Unauthorized request
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // 200 : success
        return response()->json(
            [
                'user' => $user,
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
}
