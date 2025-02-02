<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPatient
{
    public function handle(Request $request, Closure $next) //Vérifie si l'utilisateur est un patient
    {
        if (Auth::user()->doctor || Auth::user()->admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}

