<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;
 
class AvailabilityController extends Controller
{
    public function createAvailability(Request $request){
        $validated = $request->validate([
            'doctor_id' => 'required|integer',
            'start_datetime' => 'required|date_format:Y-m-d H:i',
            'end_datetime' => 'required|date_format:Y-m-d H:i|after:start_datetime',
        ]);

        if($validated['start_datetime'] < now()) {
            return response()->json(['message' => 'Availability start date must be in the future'], 400);
        }

        if($validated['end_datetime'] < now()) {
            return response()->json(['message' => 'Availability end date must be in the future'], 400);
        }

        if($validated['start_datetime'] > $validated['end_datetime']) {
            return response()->json(['message' => 'Availability start date must be before end date'], 400);
        }

        $user = Auth::user();
        
        if ((int)$validated['doctor_id'] !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        




        // Check for overlapping availabilities
        $overlappingAvailability = Availability::where('doctor_id', $validated['doctor_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_datetime', [$validated['start_datetime'], $validated['end_datetime']])
                      ->orWhereBetween('end_datetime', [$validated['start_datetime'], $validated['end_datetime']])
                      ->orWhere(function ($query) use ($validated) {
                          $query->where('start_datetime', '<=', $validated['start_datetime'])
                                ->where('end_datetime', '>=', $validated['end_datetime']);
                      });
            })
        ->exists();

        if ($overlappingAvailability) {
            return response()->json(['message' => 'Availability overlaps with an existing availability'], 400);
        }

        $availability = Availability::create([
            'doctor_id' => $validated['doctor_id'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
        ]);

        return response()->json([
            'message' => 'Availability created successfully',
            'availability' => $availability,
        ], 201);
    }


    public function getAvailability(Request $request)
    {   
        $id = Auth::user()->id;

        $availabilities = Availability::where('doctor_id', $id)
            ->get();

        if($availabilities->isEmpty()) {
            return response()->json(['message' => 'No availabilities found'], 404);
        }

        return response()->json([
            'message' => 'Availabilities retrieved successfully',
            'availabilities' => $availabilities,
        ]);
    }

    public function deleteAvailability(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $availability = Availability::find($validated['id']);
        if (! $availability) {
            return response()->json(['message' => 'Availability not found'], 404);
        }

        $availability->delete();

        return response()->json(['message' => 'Availability deleted successfully']);
    }
}
