<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::where('role', 'staff')->paginate(10);
        return response()->json([
            'data' => $staffs,
            "success" => true,
            'message' => 'success'
        ],200);
    }



    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $staff = User::where('role', 'staff')->with('departement')->find($id);
        if ($staff) {
            return response()->json([
                'data' => $staff,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'staff not found',
            'seccess' => false
        ],404);
    }
  
}
