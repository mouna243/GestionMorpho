<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Paiment;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Paiments = Paiment::paginate(10);

        return response()->json([
            'data' => $Paiments
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Reservation $reservation)
    {
        $Paiment = Paiment::create([
            'date' => now(),
            'prix' => $reservation->prix,
            'reservation_id' => $reservation->id
        ]);

        if ($Paiment) {
            return response()->json([
                'data' => $Paiment,
                'success' => true
            ],201);
        }

        return response()->json([
            'message' => "Paiment not created",
            'success' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $Paiment = Paiment::with('reservation.chamber', 'reservation.client')->find($id);
        if ($Paiment) {
            return response()->json([
                'data' => $Paiment,
                'success' => true
            ],200);
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
            ],204);
        }
        return response()->json([
            'message' => 'Paiment is not deleted',
            'success' => false
        ],400);
    }
}
