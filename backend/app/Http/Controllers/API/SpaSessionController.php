<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpaSession;
use Illuminate\Http\Request;

class SpaSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spaSessions = SpaSession::all();
        if ($spaSessions) {
            return response()->json([
                'data' => $spaSessions,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'spaSessions not found',
            'seccess' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_spa_session_id' => 'required|integer',
            'client_id'=>'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix'=>'required|float',
            'type' => 'required|string',
        ]);

        $spaSession = SpaSession::create([
            'type_spa_session_id' => $request->type_spa_session_id,
            'client_id'=>$request->client_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'prix'=>$request->prix,
            'type' => $request->type,
        ]);
        if ($spaSession) {
            return response()->json([
                'data' => $spaSession,
                'success' => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'spaSession not created',
            'success' => false
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $SpaSession = SpaSession::find($id);
        if ($SpaSession) {
            return response()->json([
                'data' => $SpaSession,
                'success' => true
            ]);
        }

        return response()->json([
            'message' => 'the SpaSession not found',
            'success' => false
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpaSession $spaSession)
    {
        $request->validate([
            'type_spa_session_id' => 'required|integer',
            'client_id'=>'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'prix'=>'required|float',
        ]); 
        $spaSession->update([
            'type_spa_session_id' => $request->type_spa_session_id,
            'client_id'=>$request->client_id,   
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'prix'=>$request->prix,
        ]);

        if ($spaSession) {
            return response()->json([
                'data' => $spaSession,
                'success' => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'spaSession not updated',
            'success' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SpaSession $spaSession)
    {
        $is_deleted = $spaSession->delete();
        if ($is_deleted) {
            return response()->json([
                'message' => 'spaSession is deleted',
                'success' => true
            ]);
        }
        return response()->json([
            'message' => 'spaSession is not deleted',
            'success' => false
        ]);
    }
}
