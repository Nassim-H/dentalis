<?php
session_start(); // Démarrer la session pour stocker les informations utilisateur

// Activer le mode débogage pour voir les erreurs (désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$responseMessage = "";  // Message de retour pour l'affichage des erreurs

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécuriser les entrées utilisateur
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier si les champs sont remplis
    if (empty($email) || empty($password)) {
        $responseMessage = "Tous les champs sont obligatoires.";
    } else {
        // URL de l'endpoint de connexion de l'API
        $url = 'http://127.0.0.1:8000/api/users/login'; 

        // Données à envoyer à l'API
        $data = json_encode([
            'email' => $email,
            'password' => $password
        ]);

        // Initialisation de cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Exécution de la requête
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch); // Récupérer l'erreur cURL si existante

        curl_close($ch); // Fermer la connexion cURL

        // Vérifier si cURL a rencontré une erreur
        if ($curlError) {
            $responseMessage = 'Erreur de connexion au serveur : ' . $curlError;
        } else {
            // Décoder la réponse JSON
            $result = json_decode($response, true);

            // Debugging : afficher la réponse API (désactiver en production)
            echo "<pre>Réponse API : " . htmlspecialchars($response) . "</pre>";

            if ($httpCode == 200 && isset($result['token'])) {
                // Stocker le token de l'utilisateur en session
                $_SESSION['token'] = $result['token'];
                $_SESSION['email'] = $email; // Optionnel, pour garder l'email en session

                // Rediriger vers accueil2.php après la connexion réussie
                header("Location: accueil2.php");
                exit();
            } else {
                // Afficher le message d'erreur retourné par l'API
                $responseMessage = isset($result['message']) ? $result['message'] : "Identifiants incorrects.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/connexion.css">
    <title>Connexion</title>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>

        <?php if (!empty($responseMessage)) : ?>
            <p style="color: red;"><?php echo htmlspecialchars($responseMessage); ?></p>
        <?php endif; ?>

        <form class="login-form" method="POST" action="">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>

            <p class="forgot-password">
                <a href="#">Mot de passe oublié ?</a>
            </p>
            
            <p class="register-link">
                Pas encore inscrit ? <a href="inscription.php">Créer un compte</a>
            </p>
        </form>
    </div>
</body>
</html>
