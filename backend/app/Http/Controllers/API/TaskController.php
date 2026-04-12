<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate(10);

        return response()->json([
            'data' => $tasks,
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'departement_id' => 'required|integer',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'departement_id' => $request->departement_id
        ]);

        if ($task) {
            return response()->json([
                'data' => $task,
                "success" => true,
                'message' => 'success'
            ],201);
        }
        return response()->json([
            'message' => 'task not created',
            'seccess' => false
        ],401);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $dapartement = Task::with('departement')->find($id);

        if ($dapartement) {
            return response()->json([
                'data' => $dapartement,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'task not found',
            'seccess' => false
        ],404);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'is_completed' => 'required|boolean',
            'departement_id' => 'required|integer',
        ]);

        $is_updated = $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_completed' => $request->is_completed,
            'departement_id' => $request->departement_id
        ]);

        if ($is_updated) {
            return response()->json([
                'data' => $task,
                "success" => true,
                'message' => 'success'
            ],200);
        }
        return response()->json([
            'message' => 'task not updated',
            'seccess' => false
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $is_deleted = $task->delete();

        if ($is_deleted) {
            return response()->json([
                'message' => 'task is deleted',
                'success' => true
            ],204);
        }
        return response()->json([
            'message' => 'task is not deleted',
            'success' => false
        ],400);
    }
}
