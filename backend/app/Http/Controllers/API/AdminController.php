<?php

namespace App\Http\Controllers\API;

use App\Models\Absences;
use App\Models\Chamber;
use App\Models\Plat;
use App\Models\Workshift;
use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $staffs = User::with('departements')->where('role', 'staff')->paginate(10);
        return response()->json(['data' => $staffs, 'success' => true], 200);
    }

    public function stats()
    {
        return response()->json([
            'data' => [
                'total_chambres'    => Chamber::count(),
                'chambres_dispo'    => Chamber::where('is_available', true)->count(),
                'total_plats'       => Plat::count(),
                'plats_dispo'       => Plat::where('is_available', true)->count(),
                'total_staff'       => User::where('role', 'staff')->count(),
                'total_departements'=> Departement::count(),
                'total_workshifts'  => Workshift::count(),
                'total_absences'    => Absences::count(),
                'absences_justifiees'   => Absences::where('is_justified', true)->count(),
                'absences_non_justifiees' => Absences::where('is_justified', false)->count(),
            ],
            'success' => true
        ], 200);
    }

    public function absences()
    {
        $absences = Absences::with(['staff', 'workshift'])->latest()->get();
        return response()->json(['data' => $absences, 'success' => true], 200);
    }
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
            'experiences' => 'nullable|array',
            "experiences.*.title" => 'string',
            "experiences.*.description" => 'string',
            "experiences.*.date_debut" => 'date',
            "experiences.*.date_fin" => 'date',
            "experiences.*.entreprise" => 'string',
            'langages' => 'nullable|array',
            "langages.*.name" => 'string',
            "langages.*.level" => 'string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephon' => $request->telephon,
            'CIN' => $request->CIN,
            'age' => $request->age,
            'role' => 'staff',
            'salaire' => $request->salaire,
            'departement_id' => $request->departement_id,
            'experiences' => $request->experiences ?? [],
            'langages' => $request->langages ?? [],
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
            'experiences' => 'nullable|array',
            "experiences.*.title" => 'string',
            "experiences.*.description" => 'string',
            "experiences.*.date_debut" => 'date',
            "experiences.*.date_fin" => 'date',
            "experiences.*.entreprise" => 'string',
            'langages' => 'nullable|array',
            "langages.*.name" => 'string',
            "langages.*.level" => 'string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephon' => $request->telephon,
            'CIN' => $request->CIN,
            'age' => $request->age,
            'role' => 'staff',
            'salaire' => $request->salaire,
            'departement_id' => $request->departement_id,
            'experiences' => $request->experiences ?? [],
            'langages' => $request->langages ?? [],
        ]);
        $user = $user->fresh();

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
