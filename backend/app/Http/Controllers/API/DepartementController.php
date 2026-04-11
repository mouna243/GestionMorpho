<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $departements = Departement::all();

     if ($departements) {
         return response()->json([
             'data' => $departements,
             "success" => true,
             'message' => 'success'
         ]);
     }
     return response()->json([
         'message' => 'departements not found',
         'seccess' => false
     ]);
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
            ]);
        }
        return response()->json([
            'message' => 'departement not created',
            'seccess' => false
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $dapartement = Departement::find($id);

        if ($dapartement) {
            return response()->json([
                'data' => $dapartement,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'departement not found',
            'seccess' => false
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string|max:500',
            'is_available'=>'required|boolean',
        ]);

        $is_updated = $departement->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'is_available'=>$request->is_available
        ]);

        if ($is_updated) {
            return response()->json([
                'data' => $departement,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'departement not updated',
            'seccess' => false
        ]);
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
            ]);
        }
        return response()->json([
            'message' => 'departement is not deleted',
            'success' => false
        ]);
    }
}
