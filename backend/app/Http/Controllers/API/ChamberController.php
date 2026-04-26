<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChamberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chambers = Chamber::with('chamber_type')->paginate(10);
        return response()->json([
            'data' => $chambers
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "image" => "required|image|mimes:jpg,png,jpeg|max:2048",
            "description" => "required|string|max:500",
            "is_available" => "required",
            "chamber_type_id" => "required",
        ]);

        $file = $request->file('image');
        $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('chamberImages', $name, 'public');

        $chamber = Chamber::create([
            "name" => $request->name,
            "image" => $path,
            "description" => $request->description,
            "is_available" => $request->is_available,
            "chamber_type_id" => $request->chamber_type_id
        ]);

        if ($chamber) {
            return response()->json([
                "data" => $chamber,
                "message" => "chamber created successfully",
                "success" => true
            ], 201);
        }
        return response()->json([
            "message" => "chamber create failed",
            "success" => false
        ], 401);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $chamber = Chamber::with('chamber_type')->find($id);

        if ($chamber) {
            return response()->json([
                'data' => $chamber,
                'success' => true
            ],200);
        }
        return response()->json([
            'success' => false
        ], 404);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chamber $chamber)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "image" => "image|mimes:jpg,png,jpeg|max:2048",
            "description" => "required|string|max:500",
            "is_available" => "required|boolean",
            "chamber_type_id" => "required",
        ]);


        if ($request->hasFile("image")) {
            if ($chamber->image && Storage::exists($chamber->image)) {
                Storage::delete($chamber->image);
            }
            $file = $request->file('image');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('chamberImages', $name, 'public');
        } else {
            $path = $chamber->image;
        }

        $is_updated = $chamber->update([
            "name" => $request->name,
            "image" => $path,
            "description" => $request->description,
            "is_available" => $request->is_available,
            "chamber_type_id" => $request->chamber_type_id
        ]);

        if (!$is_updated) {
            return response()->json([
                'message' => "chamber is not updated",
                'success' => false
            ], 200);
        }

        return response()->json([
            'message' => "chamber is updated",
            'success' => true
        ], 400);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chamber $chamber)
    {
        $is_deleted = $chamber->delete();
        if ($is_deleted) {
            if ($chamber->image && Storage::exists($chamber->image)) {
                Storage::delete($chamber->image);
            }
            return response()->json([
                'message' => "chamber is deleted successfuly",
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => "chamber is not deleted ",
            'success' => false
        ],400);

    }
}
