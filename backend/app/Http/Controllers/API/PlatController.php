<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plats = Plat::paginate(10);

        return response()->json([
            'data' => $plats
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plats',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string|max:500',
            'prix' => 'required|numeric'
        ]);

        $file = $request->file('image');
        $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('platImages', $name, 'public');

        $plat = Plat::create([
          'name' => $request->name,
            'image' => $path,
            'description' => $request->description,
            'prix' => $request->prix
        ]);

        if ($plat) {
            return response()->json([
                "data" => $plat,
                "message" => "plat created successfully",
                "success" => true
            ], 201);
        }
        return response()->json([
            "message" => "plat create failed",
            "success" => false
        ], 401);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $plat = Plat::find($id);

        if ($plat) {
            return response()->json([
                'data' => $plat,
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
    public function update(Request $request, Plat $plat)
    {
        $request->validate([
         'name' => 'required|string|max:255|unique:plats',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'required|string|max:500',
            'prix' => 'required|numeric',
            'is_available' => 'required|boolean'
        ]);


        if ($request->hasFile("image")) {
            if ($plat->image && Storage::exists($plat->image)) {
                Storage::delete($plat->image);
            }
            $file = $request->file('image');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('platImages', $name, 'public');
        } else {
            $path = $plat->image;
        }

        $is_updated = $plat->update([
            'name' => $request->name,
            'image' => $path,
            'description' => $request->description,
            'prix' => $request->prix,
            'is_available' => $request->is_available
        ]);

        if (!$is_updated) {
            return response()->json([
                'message' => "plat is not updated",
                'success' => false
            ], 400);
        }

        return response()->json([
            'message' => "plat is updated",
            'success' => true
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plat $plat)
    {
        $is_deleted = $plat->delete();
        if ($is_deleted) {
            if ($plat->image && Storage::exists($plat->image)) {
                Storage::delete($plat->image);
            }
            return response()->json([
                'message' => "plat is deleted successfuly",
                'success' => true
            ], 200);
        }
        return response()->json([
            'message' => "plat is not deleted ",
            'success' => false
        ], 400);

    }
}
