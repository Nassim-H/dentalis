<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // 🧑‍⚕️ RDV reçus par le médecin connecté
    public function indexDoctor()
    {
        $user = Auth::user();

        $appointments = $user->receivedAppointments()
            ->with('client')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json(['appointments' => $appointments]);
    }

    // 👤 RDV pris par le patient connecté
    public function indexPatient()
    {
        $user = Auth::user();

        $appointments = $user->appointments()
            ->with('doctor')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json(['appointments' => $appointments]);
    }

    // 📅 Créer un RDV
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'required|date_format:Y-m-d H:i:s',
            'duration' => 'required|integer|min:5|max:180',
            'description' => 'required|string|max:255',
        ]);

        $client = Auth::user();
        $start = new \DateTime($validated['date']);
        $end = (clone $start)->modify("+{$validated['duration']} minutes");

        $isAvailable = Availability::where('doctor_id', $validated['doctor_id'])
            ->where('start_datetime', '<=', $start)
            ->where('end_datetime', '>=', $end)
            ->exists();

        if (!$isAvailable) {
            return response()->json(['message' => 'Ce créneau ne fait pas partie des disponibilités du docteur.'], 422);
        }

        $hasConflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('date', [$start, $end])
                    ->orWhereRaw('? BETWEEN date AND DATE_ADD(date, INTERVAL duration MINUTE)', [$start])
                    ->orWhereRaw('? BETWEEN date AND DATE_ADD(date, INTERVAL duration MINUTE)', [$end]);
            })
            ->exists();

        if ($hasConflict) {
            return response()->json(['message' => 'Ce créneau est déjà réservé.'], 422);
        }

        $appointment = Appointment::create([
            'client_id' => $client->id,
            'doctor_id' => $validated['doctor_id'],
            'date' => $validated['date'],
            'duration' => $validated['duration'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Rendez-vous créé avec succès.',
            'appointment' => $appointment,
        ], 201);
    }

    // ✏️ Modifier un RDV (patient)
    public function update($id, Request $request)
    {
        $user = Auth::user();
        $appointment = Appointment::findOrFail($id);

        if ($appointment->client_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d H:i:s',
            'duration' => 'required|integer|min:5|max:180',
            'description' => 'required|string|max:255',
        ]);

        $start = new \DateTime($validated['date']);
        $end = (clone $start)->modify("+{$validated['duration']} minutes");

        $isAvailable = Availability::where('doctor_id', $appointment->doctor_id)
            ->where('start_datetime', '<=', $start)
            ->where('end_datetime', '>=', $end)
            ->exists();

        if (!$isAvailable) {
            return response()->json(['message' => 'Hors des disponibilités du docteur.'], 422);
        }

        $hasConflict = Appointment::where('doctor_id', $appointment->doctor_id)
            ->where('id', '!=', $appointment->id)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('date', [$start, $end])
                    ->orWhereRaw('? BETWEEN date AND DATE_ADD(date, INTERVAL duration MINUTE)', [$start])
                    ->orWhereRaw('? BETWEEN date AND DATE_ADD(date, INTERVAL duration MINUTE)', [$end]);
            })
            ->exists();

        if ($hasConflict) {
            return response()->json(['message' => 'Conflit avec un autre rendez-vous.'], 422);
        }

        $appointment->update([
            'date' => $validated['date'],
            'duration' => $validated['duration'],
            'description' => $validated['description'],
        ]);

        return response()->json(['message' => 'Rendez-vous modifié.']);
    }

    // 🗑️ Supprimer un RDV (patient ou admin)
    public function destroy($id)
    {
        $user = Auth::user();
        $appointment = Appointment::findOrFail($id);

        if ($appointment->client_id !== $user->id && !$user->admin) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Rendez-vous supprimé.']);
    }

    public function publicIndex($doctorId)
{
    $appointments = \App\Models\Appointment::where('doctor_id', $doctorId)
        ->orderBy('date', 'asc')
        ->get();

    return response()->json(['appointments' => $appointments]);
}

}
