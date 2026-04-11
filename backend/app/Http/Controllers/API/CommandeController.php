<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Plat;
use Illuminate\Http\Request;
use function Illuminate\Support\now;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::all();

        return response()->json([
            'data' => $commandes,
            'message' => 'success',
            "success" => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'service_id' => 'required|integer',
            'plats' => 'required|array',
            'plats.*.plat_id' => 'required|integer',
            'plats.*.quantite' => 'required|integer',
        ]);
        $date = now();
        $prix = 0;
        foreach ($request->plats as $plat) {
            $prix += $plat['quantite'] * Plat::find($plat['plat_id'])->prix;
        }

        $commande = Commande::create([
            'date' => $date,
            'prix' => $prix,
            'client_id' => $request->client_id,
            'service_id' => $request->service_id,
        ]);

        foreach ($request->plats as $plat) {
            $commande->plats()->attach($plat['plat_id'], ['quantite' => $plat['quantite']]);
        }
        if ($commande) {
            return response()->json([
                'data' => $commande,
                'message' => 'success',
                'success' => true
            ]);
        }
        return response()->json([
            'message' => 'failed',
            'success' => false
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $commande = Commande::with('plats')->find($id);
        if ($commande) {
            return response()->json([
                'data' => $commande,
                'success' => true
            ]);
        }

        return response()->json([
            'message' => 'the commande not found',
            'success' => false
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'service_id' => 'required|integer',
            'plats' => 'required|array',
            'plats.*.plat_id' => 'required|integer',
            'plats.*.quantite' => 'required|integer',
        ]);

        $prix = 0;

        $commande->plats()->delete();



        $commade_updated = $commande->update([
            'date' => now(),
            'prix' => $prix,
            'client_id' => $request->client_id,
            'service_id' => $request->service_id,
        ]);

        foreach ($request->plats as $plat) {
            $prix += $plat['quantite'] * Plat::find($plat['plat_id'])->prix;
        }

      if($commade_updated){
            return response()->json([
            'data' => $commande,
            'message' => 'success',
            'seccess' => true
        ]);
      }

        return response()->json([
            'message' => 'failed',
            'success' => false
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        $commande->plats()->delete();
        $is_deleted = $commande->delete();

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
