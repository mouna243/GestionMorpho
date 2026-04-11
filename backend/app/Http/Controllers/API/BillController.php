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
        $bills = Bill::all();
        if ($bills) {
            return response()->json([
                'data' => $bills,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'bills not found',
            'seccess' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCommandeBill(Request $request, Commande $commande)
    {
        $request->validate([
            "montant" => 'required|float'
        ]);

        $bill = $commande->bills()->create([
            "montant" => $request->montant
        ]);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'bill not created',
            'seccess' => false
        ]);
    }

    public function storeSpaSessionBill(Request $request, SpaSession $spaSession)
    {
        $request->validate([
            "montant" => 'required|float'
        ]);

        $bill = $spaSession->bills()->create([
            "montant" => $request->montant
        ]);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'bill not created',
            'seccess' => false
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $bill = Bill::find($id);

        if ($bill) {
            return response()->json([
                'data' => $bill,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'bill not found',
            'seccess' => false
        ]);
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
            ]);
        }
        return response()->json([
            'message' => 'bill is not deleted',
            'success' => false
        ]);
    }
}
