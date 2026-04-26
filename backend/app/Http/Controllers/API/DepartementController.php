<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $departements = Departement::paginate(10);

        return response()->json([
            'data' => $departements,
            "success" => true,
            'message' => 'success'
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name'=>'required|string|max:255',
        'description'=>'required|string|max:500',
        ]);

        $departement = Departement::create([
            'name'=>$request->name,
            'description'=>$request->description,
        ]);

        if ($departement) {
            return response()->json([
                'data' => $departement,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'departement not created',
            'seccess' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $dapartement = Departement::with('staffs')->find($id);

        if ($dapartement) {
            return response()->json([
                'data' => $dapartement,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'departement not found',
            'seccess' => false
        ],404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:500',
            'is_active'=>'required|boolean',
        ]);

        $is_updated = $departement->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'is_active'=>$request->is_active
        ]);

        if ($is_updated) {
            return response()->json([
                'data' => $departement,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'departement not updated',
            'seccess' => false
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        $is_deleted = $departement->delete();
        
        if ($is_deleted) {
            return response()->json([
                'message' => 'departement is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'departement is not deleted',
            'success' => false
        ],400);
    }
}
