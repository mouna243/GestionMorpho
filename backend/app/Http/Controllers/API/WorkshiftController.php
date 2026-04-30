<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Workshift;
use Illuminate\Http\Request;

class WorkshiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $workshifts = Workshift::paginate(10);

        return response()->json([
             'data' => $workshifts,
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
            'departement_id'=>'required|integer',
            'date_debut'=>'required|date',
            'date_fin' => 'required|date',
            'check_in' => 'required|string',
            'check_out' => 'required|string',
        ]);

        $workshift = Workshift::create([
            'departement_id' => $request->departement_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out
        ]);

        if ($workshift) {
            return response()->json([
                'data' => $workshift,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'workshift not created',
            'seccess' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $dapartement = Workshift::with('departement')->find($id);

        if ($dapartement) {
            return response()->json([
                'data' => $dapartement,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'workshift not found',
            'seccess' => false
        ],404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Workshift $workshift)
    {
        $request->validate([
            'departement_id'=>'required|integer',
            'date_debut'=>'required|date',
            'date_fin' => 'required|date',
            'check_in' => 'required|string',
            'check_out' => 'required|string',
        ]);

        $is_updated = $workshift->update([
            'departement_id' => $request->departement_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out
        ]);

        if ($is_updated) {
            return response()->json([
                'data' => $workshift,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'workshift not updated',
            'seccess' => false
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshift $workshift)
    {
        $is_deleted = $workshift->delete();
        
        if ($is_deleted) {
            return response()->json([
                'message' => 'workshift is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'workshift is not deleted',
            'success' => false
        ],400);
    }
}
