<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SpaSession;
use App\Models\TypeSpaSession;
use Illuminate\Http\Request;

class SpaSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spaSessions = SpaSession::paginate(10);

        return response()->json([
            'data' => $spaSessions,
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
            'type_spa_session_id' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);

        $type = TypeSpaSession::find($request->type_spa_session_id);

        $spaSession = SpaSession::create([
            'type_spa_session_id' => $request->type_spa_session_id,
            'client_id'=> auth()->user()->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'prix'=> $type->prix ,
        ]);

        if ($spaSession) {
            return response()->json([
                'data' => $spaSession,
                'success' => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'spaSession not created',
            'success' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $SpaSession = SpaSession::with('client', 'type_spa_session')->find($id);
        if ($SpaSession) {
            return response()->json([
                'data' => $SpaSession,
                'success' => true
            ],200);
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
            'date_debut' => 'required|date',
            'date_fin' => 'required|date'
        ]); 

        $type = TypeSpaSession::find($request->type_spa_session_id);

        $spaSession->update([
            'type_spa_session_id' => $request->type_spa_session_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'prix'=> $type->prix
        ]);

        if ($spaSession) {
            return response()->json([
                'data' => $spaSession,
                'success' => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'spaSession not updated',
            'success' => false
        ],400);
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
            ],204);
        }
        return response()->json([
            'message' => 'spaSession is not deleted',
            'success' => false
        ],400);
    }
}
