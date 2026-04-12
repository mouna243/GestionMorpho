<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Plat;
use App\Models\Service;
use Illuminate\Http\Request;
use function Illuminate\Support\now;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::paginate(10);

        return response()->json([
            'data' => $commandes,
            'message' => 'success',
            "success" => true
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
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
            'client_id' => auth()->user()->id,
            'service_id' => $service->id,
        ]);

        foreach ($request->plats as $plat) {
            $commande->plats()->attach($plat['plat_id'], ['quantite' => $plat['quantite']]);
        }

        if ($commande) {
            return response()->json([
                'data' => $commande,
                'message' => 'success',
                'success' => true
            ],201);
        }
        return response()->json([
            'message' => 'failed',
            'success' => false
        ],401);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $commande = Commande::with('plats', 'client')->find($id);
        if ($commande) {
            return response()->json([
                'data' => $commande,
                'success' => true
            ],200);
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
            'plats' => 'required|array',
            'plats.*.plat_id' => 'required|integer',
            'plats.*.quantite' => 'required|integer',
        ]);

        $prix = 0;

        $commande->plats()->delete();

        foreach ($request->plats as $plat) {
            $commande->plats()->attach($plat['plat_id'], ['quantite' => $plat['quantite']]);
            $prix += $plat['quantite'] * Plat::find($plat['plat_id'])->prix;
        }

        $commade_updated = $commande->update([
            'date' => now(),
            'prix' => $prix,
        ]);

      if($commade_updated){
            return response()->json([
            'data' => $commande,
            'message' => 'success',
            'seccess' => true
        ],200);
      }

        return response()->json([
            'message' => 'failed',
            'success' => false
        ],400);

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
            ],204);
        }
        return response()->json([
            'message' => 'Paiment is not deleted',
            'success' => false
        ],400);
    }
}
