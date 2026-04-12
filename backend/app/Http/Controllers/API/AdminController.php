<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function storeRH(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'telephon' => 'required|string|min:10|max:20',
            'CIN' => 'required|string|unique:users',
            'age' => 'required|integer|min:18|max:100',
            'salaire' => 'required|string',
            'departement_id' => 'required|integer',
            'experiences' => 'required|array',
            "experiences.*.title" => 'required|string',
            "experiences.*.description" => 'required|string',
            "experiences.*.date_debut" => 'required|date',
            "experiences.*.date_fin" => 'required|date',
            "experiences.*.entreprise" => 'required|string',
            'langages' => 'required|array',
            "langages.*.name" => 'required|string',
            "langages.*.level" => 'required|string',
        ]);

        $departement = Departement::where('name', "RH")->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephon' => $request->telephon,
            'CIN' => $request->CIN,
            'age' => $request->age,
            'role' => 'staff',
            'salaire' => $request->salaire,
            'departement_id' => $departement->id,
            'experiences' => $request->experiences,
            'langages' => $request->langages,
        ]);

        if($user){
            return response()->json([
                'data' => $user,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'user not created',
            'seccess' => false
        ],401);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function updateRH(Request $request,User $user)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'telephon' => 'required|string|min:10|max:20',
            'CIN' => 'required|string|unique:users',
            'age' => 'required|integer|min:18|max:100',
            'salaire' => 'required|string',
            'departement_id' => 'required|integer',
            'experiences' => 'required|array',
            "experiences.*.title" => 'required|string',
            "experiences.*.description" => 'required|string',
            "experiences.*.date_debut" => 'required|date',
            "experiences.*.date_fin" => 'required|date',
            "experiences.*.entreprise" => 'required|string',
            'langages' => 'required|array',
            "langages.*.name" => 'required|string',
            "langages.*.level" => 'required|string',
        ]);

        $departement = Departement::where('name', "RH")->first();

        $user =$user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephon' => $request->telephon,
            'CIN' => $request->CIN,
            'age' => $request->age,
            'role' => 'staff',
            'salaire' => $request->salaire,
            'departement_id' => $departement->id,
            'experiences' => $request->experiences,
            'langages' => $request->langages,
        ]);

        if($user){
            return response()->json([
                'data' => $user,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'RH not found',
            'seccess' => false
        ],400);
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(User $user)
    {
        $is_deleted = $user->delete();

        if($is_deleted){
            return response()->json([
                'message' => 'staff is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'staff is not deleted',
            'success' => false
        ],400);
    }

        
  
}
