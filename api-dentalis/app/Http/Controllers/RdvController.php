<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Apt_Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ValidatedInput;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use PharIo\Manifest\Email;

class RdvController extends Controller
{
    /**
     * Create a new appointement for the current user.
     */
    public function createRdvPatient(Request $request){   
        $request->validate([
            'date' => 'required|date',
            'duration' => 'required|integer',
            'doctor_id' => 'required|integer',
            'description' => 'string',
        ]);
        
        $user = $request->user();
        
        $rdv = new Appointment();
        $rdv->client_id = $user->id;
        $rdv->date = $request->date;
        $rdv->duration = $request->duration;
        $rdv->description = $request->description;

        $apt_doctor = new Apt_Doctor();
        $apt_doctor->id_doctors = $request->doctor_id;
        
        
        $rdv->save();

        $apt_doctor->id_apt = $rdv->id; 

        $apt_doctor->save();
        
        return response()->json($rdv, 201);
    }

    /**
     * Get the appointements of the current user.
     */
    public function getRdvPatient(Request $request){
        $user = $request->user();
        $rdvs = Appointment::where('client_id', $user->id)->get();
        return response()->json($rdvs, 200);
    }
}
