<?php

// Importe les classes nécessaires pour configurer et exécuter l'application Laravel.
use Illuminate\Foundation\Application; // Classe principale pour la configuration de l'application.
use Illuminate\Foundation\Configuration\Exceptions; // Gestionnaire des exceptions personnalisées.
use Illuminate\Foundation\Configuration\Middleware; // Gestionnaire des middlewares.

// Retourne une instance configurée de l'application Laravel.
return Application::configure(
    // Définit le chemin de base de l'application (généralement le répertoire parent).
    basePath: dirname(__DIR__)
)
    // Configure le système de routage de l'application.
    ->withRouting(
        // Chemin des routes web.
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        // Chemin des commandes console.
        commands: __DIR__.'/../routes/console.php',
        // Définition d'un endpoint pour vérifier la "santé" de l'application.
        health: '/up',
    )
    // Configure les middlewares de l'application.
    ->withMiddleware(function (Middleware $middleware) {    
        // Les middlewares globaux et spécifiques peuvent être définis ici.
        // Exemple : $middleware->alias('auth', \App\Http\Middleware\Authenticate::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdmin::class,
            'patient' => \App\Http\Middleware\CheckPatient::class,
            'doctor' => \App\Http\Middleware\CheckDoctor::class,
        ]);
    })
    // Configure le gestionnaire des exceptions de l'application.
    ->withExceptions(function (Exceptions $exceptions) {
        // Personnalisation des exceptions globales, comme les pages 404 ou 500.
        // Exemple : $exceptions->map(Exception::class, MyCustomHandler::class);
        $exceptions->renderable(function (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        });
    })
    // Crée l'instance finale de l'application.
    ->create();