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
        $chamberTypes = ChamberType::all();
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
            "discription" => 'required|string|max:500',
            "is_available" => 'required|boolean',
        ]);

        $chamberType = ChamberType::create([
            'name' => $request->name,
            'discription' => $request->discription,
            'is_available' => $request->is_available
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
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChamberType $chamberType)
    {
        $request->validate([
            "name" => 'required|string|max:255',
            "discription" => 'required|string|max:500',
            "is_available" => 'required|boolean',
        ]);

        $is_updated = $chamberType->update([
            'name' => $request->name,
            'discription' => $request->discription,
            'is_available' => $request->is_available
        ]);

        if ($is_updated) {
            return response()->json([
                "message" => " type chamber is updated ",
                'success' => true
            ]);
        }

        return response()->json([
            "message" => " type chamber is not updated ",
            'success' => false
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChamberType $chamberType)
    {
        $is_deleted = $chamberType->delete();
        if (!$is_deleted) {
            return response()->json([
                'message' => " type chamber is deleted ",
                'success' => true
            ]);
        }
        return response()->json([
            'message' => " type chamber is not deleted ",
            'success' => false
        ]);
    }
}
