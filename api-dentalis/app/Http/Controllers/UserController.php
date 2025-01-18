<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\ValidatedInput;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use PharIo\Manifest\Email;

class UserController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request){   
        
        $validated = $request->validate([
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'email' => 'email|unique:users',
            'password' => 'string|min:8',
        ]);
        

        // Création de l'utilisateur
        $user = User::create([
            'last_name' => $validated['lastName'],
            'first_name' => $validated['firstName'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hashage du mot de passe
        ]);

        event(new Registered($user));

        $user->sendEmailVerificationNotification();

        // Retourner une réponse avec l'utilisateur et un token
        return response()->json([
            'message' => 'Utilisateur créé avec succès. Veuillez vérifier votre email pour activer votre compte.',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request){
        
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Recherche de l'utilisateur
        $user = User::where('email', $validated['email'])->first();

        // Vérification de l'utilisateur
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Les informations d\'identification sont incorrectes.'], 401);
        }

        // Retourner une réponse avec l'utilisateur et un token
        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    /**
     * Handle user profile.
     */
    public function me(Request $request){
        return response()->json($request->user());
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    /**
     * Handle user deletion.
     */
    public function delete(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];
        $user = User::where('email', $email)->first();
        if (! $user) {
            return response()->json(['message' => 'Utilisateur introuvable.'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès.']);
    }


    /**
     * Handle user update.
     */
    public function updateUser(Request $request){
        // Validate the input
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'is_admin' => 'required',
                'is_doctor' => 'required',
            ]
        );

        // Find the user by email
        $email = $validated['email'];
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user roles
        $user->admin = $validated['is_admin'];
        $user->doctor = $validated['is_doctor'];
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }


    /**
     * Handle email verification.
     */
    public function verifyEmail(EmailVerificationRequest $request){
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully']);
    }
}
