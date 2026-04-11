<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Paiment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Paiments = Paiment::all();

        return response()->json([
            'data' => $Paiments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             'date'=>'required|date',
            'prix' => 'required|float',
            'reservation_id'=>'required|integer'
        ]);

        $Paiment = Paiment::create([
             'date' => $request->date,
            'prix' => $request->prix,
            'reservation_id' => $request->reservation_id
            
        ]);

        if ($Paiment) {
            return response()->json([
                'data' => $Paiment,
                'success' => true
            ]);
        }

        return response()->json([
            'message' => "Paiment not created",
            'success' => false
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $Paiment = Paiment::find($id);
        if ($Paiment) {
            return response()->json([
                'data' => $Paiment,
                'success' => true
            ]);
        }

        return response()->json([
            'message' => 'the Paiment not found',
            'success' => false
        ], 404);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiment $Paiment)
    {
        $is_deleted = $Paiment->delete();
        if ($is_deleted) {
            return response()->json([
                'message' => 'Paiment is deleted',
                'success' => true
            ]);
        }
        return response()->json([
            'message' => 'Paiment is not deleted',
            'success' => false
        ]);
    }
}
