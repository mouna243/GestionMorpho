<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AbscenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $absences = Absences::paginate(10);
        return response()->json([
            'data' => $absences,
            "success" => true,
            'message' => 'success'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'workshit_id' => 'required|integer',
            'staff_id' => 'required|integer'
        ]);

        $absence = Absences::create([
            'workshit_id' => $request->workshit_id,
            'staff_id' => $request->staff_id
        ]);

        if ($absence) {
            return response()->json([
                'data' => $absence,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'absence not created',
            'seccess' => false
        ]);
      
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $absences_update = Absences::with('staff', 'workshit.departement')->find($id);

        if ($absences_update) {
            return response()->json([
                'data' => $absences_update,
                "success" => true,
                'message' => 'success'
            ]);
        }
        return response()->json([
            'message' => 'absences not found',
            'seccess' => false
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absences $absences)
    {
        
        $request->validate([
            'workshit_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'is_justified' => 'required|boolean',
            'pdf' => [
                Rule::requiredIf(function () use ($request, $absences) {
                    return $request->is_justified && $absences->pdf === null;
                }),
                'file',
                'mimes:pdf',
                'max:2048',
            ],
        ]);


        if ($request->hasFile("pdf")) {
            if ($absences->pdf && Storage::exists($absences->pdf)) {
                Storage::delete($absences->pdf);
            }

            $file = $request->file('pdf');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('absencesPDF', $name, 'public');
        } else {
            $path = $absences->pdf;
        }

        $is_updated = $absences->update([
            'workshit_id' => $request->workshit_id,
            'staff_id' => $request->staff_id,
            'is_justified' => $request->is_justified,
            'pdf' => $path,
        ]);

        if ($is_updated) {
            return response()->json([
                'data' => $absences,
                "success" => true,
                'message' => 'success'
            ]);
        }

        return response()->json([
            'message' => 'absence not updated',
            'seccess' => false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absences $absences)
    {
        $is_deleted = $absences->delete();

        if($is_deleted){
            if ($absences->pdf && Storage::exists($absences->pdf)) {
                Storage::delete($absences->pdf);
            }
            return response()->json([
                'message' => 'absence is deleted',
                'success' => true
            ]);
        }
        return response()->json([
            'message' => 'absence is not deleted',
            'success' => false
        ]);
    }
}
