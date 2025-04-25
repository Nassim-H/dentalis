<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    // ✅ Dispos d'un médecin (public)
    public function indexPublic($doctorId)
    {
        $availabilities = Availability::where('doctor_id', $doctorId)
            ->orderBy('start_datetime', 'asc')
            ->get();

        return response()->json(['availabilities' => $availabilities]);
    }

    // ✅ Dispos du médecin connecté
    public function indexOwn()
    {
        $user = Auth::user();

        if (!$user->doctor) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $availabilities = Availability::where('doctor_id', $user->id)
            ->orderBy('start_datetime', 'asc')
            ->get();

        return response()->json(['availabilities' => $availabilities]);
    }

    // ✅ Ajouter un créneau
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->doctor && !$user->admin) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        $validated = $request->validate([
            'start_datetime' => 'required|date_format:Y-m-d H:i:s',
            'end_datetime' => 'required|date_format:Y-m-d H:i:s|after:start_datetime',
        ]);

        if (new \DateTime($validated['start_datetime']) < now()) {
            return response()->json(['message' => 'Date dans le passé.'], 422);
        }

        $availability = Availability::create([
            'doctor_id' => $user->id,
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
        ]);

        return response()->json([
            'message' => 'Créneau ajouté.',
            'availability' => $availability,
        ], 201);
    }

    // ✅ Supprimer un créneau
    public function destroy($id)
    {
        $user = Auth::user();
        $availability = Availability::findOrFail($id);

        if ($user->id !== $availability->doctor_id && !$user->admin) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $availability->delete();

        return response()->json(['message' => 'Créneau supprimé.']);
    }
}
