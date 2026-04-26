<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChamberType;
use Illuminate\Http\Request;

class ChamberTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //afficher tout les types de chambre
        $chamberTypes = ChamberType::with('chambers')->paginate(10);
        return response()->json([
            "data" => $chamberTypes
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required|string|max:255',
            "description" => 'required|string|max:500',
            "prix" => 'required',
        ]);

        $chamberType = ChamberType::create([
            'name' => $request->name,
            'description' => $request->description,
            'prix' => $request->prix
        ]);
        if (!$chamberType) {

            return response()->json([
                "success" => false,
                "message" => "chamber type created failed"
            ], 401);
        }
        return response()->json([
            "data" => $chamberType,
            "message" => "chamber type created successfully",
            "success" => true
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChamberType $chamberType)
    {
        $request->validate([
            "name" => 'required|string|max:255',
            "description" => 'required|string|max:500',
            'prix' => 'required|numeric',
            "is_available" => 'required|boolean',
        ]);

        $is_updated = $chamberType->update([
            'name' => $request->name,
            'description' => $request->description,
            'prix' => $request->prix,
            'is_available' => $request->is_available
        ]);

        if ($is_updated) {
            return response()->json([
                "message" => " type chamber is updated ",
                'success' => true
            ],200);
        }

        return response()->json([
            "message" => " type chamber is not updated ",
            'success' => false
        ],400);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChamberType $chamberType)
    {
        $is_deleted = $chamberType->delete();
        if ($is_deleted) {
            return response()->json([
                'message' => " type chamber is deleted ",
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => " type chamber is not deleted ",
            'success' => false
        ],400);
    }
}
