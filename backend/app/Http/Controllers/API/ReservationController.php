<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::paginate(10);

        return response()->json([
            'data' => $reservations
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_enter' => 'required|date',
            'date_sortie' => 'required|date',
            'prix' => 'required|numeric',
            'chamber_id' => 'required|integer'
        ]);

        $reservation = Reservation::create([
            'date_enter' => $request->date_entrer,
            'date_sortie' => $request->date_sortie,
            'prix' => $request->prix,
            'client_id' => auth()->user()->id,
            'chamber_id' => $request->chamber_id
        ]);

        if ($reservation) {
            return response()->json([
                'data' => $reservation,
                'success' => true
            ],201);
        }

        return response()->json([
            'message' => "reservation not created",
            'success' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $reservation = Reservation::with('chamber', 'client')->find($id);
        if ($reservation) {
            return response()->json([
                'data' => $reservation,
                'success' => true
            ],200);
        }

        return response()->json([
            'message' => 'the reservation not found',
            'success' => false
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {

        $request->validate([
            'date_enter' => 'required|date',
            'date_sortie' => 'required|date',
            'prix' => 'required|numeric',
            'chamber_id' => 'required|integer'
        ]);

        $is_updated = $reservation->update([
            'date_enter' => $request->date_entrer,
            'date_sortie' => $request->date_sortie,
            'prix' => $request->prix,
            'client_id' => auth()->user()->id,
            'chamber_id' => $request->chamber_id
        ]);

        if ($is_updated) {
            return response()->json([
                'message' => 'reservation is updated',
                'success' => true
            ],200);
        }
        return response()->json([
            'message' => 'reservation is not updated',
            'success' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $is_deleted = $reservation->delete();
        if ($is_deleted) {
            return response()->json([
                'message' => 'reservation is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'reservation is not deleted',
            'success' => false
        ],400);
    }
}
