<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeSpaSession;
use Illuminate\Http\Request;

class TypeSpaSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //afficher tout les types de chambre
        $typeSpaSessions = TypeSpaSession::paginate(10);
        return response()->json([
            "data" => $typeSpaSessions
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discription' => 'required|string|max:500',
            'prix' => 'required|float'
        ]);

        $typeSpaSession = TypeSpaSession::create([
            'name' => $request->name,
            'discription' => $request->discription,
            'prix' => $request->prix
        ]);
        if (!$typeSpaSession) {

            return response()->json([
                "success" => false,
                "message" => "type spa session created failed"
            ], 401);
        }
        return response()->json([
            "data" => $typeSpaSession,
            "message" => "type spa session created successfully",
            "success" => true
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeSpaSession $typeSpaSession)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discription' => 'required|string|max:500',
            'prix' => 'required|float',
            'is_available' => 'required|boolean',
        ]);

        $is_updated = $typeSpaSession->update([
            'name' => $request->name,
            'discription' => $request->discription,
            'prix' => $request->prix,
            'is_available' => $request->is_available
        ]);

        if ($is_updated) {
            return response()->json([
                "message" => " type spa session is updated ",
                'success' => true
            ],200);
        }

        return response()->json([
            "message" => " type spa session is not updated ",
            'success' => false
        ],400);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeSpaSession $typeSpaSession)
    {
        $is_deleted = $typeSpaSession->delete();
        if ($is_deleted) {
            return response()->json([
                'message' => " type spa session is deleted ",
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => " type spa session is not deleted ",
            'success' => false
        ],400);
    }
}
