<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Commande;
use App\Models\SpaSession;
use Illuminate\Http\Request;
use Psy\Command\Command;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::paginate(10);
        
        return response()->json([
            'data' => $bills,
            "success" => true,
            'message' => 'success'
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCommandeBill(Request $request, Commande $commande)
    {
        $bill = $commande->bills()->create([
            "montant" => $commande->prix
        ]);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'bill not created',
            'seccess' => false
        ],401);
    }

    public function storeSpaSessionBill(Request $request, SpaSession $spaSession)
    {
        $bill = $spaSession->bills()->create([
            "montant" => $spaSession->TypeSpaSession->prix
        ]);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'bill not created',
            'seccess' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $bill = Bill::with('billable')->find($id);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'bill not found',
            'seccess' => false
        ],404);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        $is_deleted = $bill->delete();
        
        if ($is_deleted) {
            return response()->json([
                'message' => 'bill is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'bill is not deleted',
            'success' => false
        ],400);
    }
}
