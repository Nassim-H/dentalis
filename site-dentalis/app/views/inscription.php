<?php
session_start(); // Démarrer la session si nécessaire
$responseMessage = "";  // Variable pour stocker la réponse de l'API

// Activer le débogage PHP (désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et sécurisation des champs
    $lastName = trim(htmlspecialchars($_POST['lastName']));
    $firstName = trim(htmlspecialchars($_POST['firstName']));
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier si les champs sont remplis
    if (empty($lastName) || empty($firstName) || empty($email) || empty($password)) {
        $responseMessage = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier la validité de l'email
        $responseMessage = "L'adresse email n'est pas valide.";
    } else {
        // Préparer les données à envoyer à l'API
        $postData = json_encode([
            'lastName' => $lastName,
            'firstName' => $firstName,
            'email' => $email,
            'password' => $password
        ]);

        // URL de l'API (remplace avec l'URL correcte)
        $apiUrl = 'http://127.0.0.1:8000/api/users/register';

        // Initialiser cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        // Exécuter la requête
        $apiResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch); // Récupérer l'erreur cURL si existante

        curl_close($ch); // Fermer la connexion cURL

        // Vérifier si cURL a rencontré une erreur
        if ($curlError) {
            $responseMessage = 'Erreur de requête : ' . $curlError;
        } else {
            // Décoder la réponse JSON de l'API
            $data = json_decode($apiResponse, true);

            // Debugging : afficher la réponse API (désactiver en production)
            echo "<pre>Réponse API : " . htmlspecialchars($apiResponse) . "</pre>";

            if ($httpCode == 201 || $httpCode == 200) {
                $responseMessage = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $responseMessage = isset($data['message']) ? $data['message'] : "Une erreur s'est produite. Code HTTP : " . $httpCode;
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
    <link rel="stylesheet" href="CSS/inscription.css">
    <title>Inscription</title>
</head>
<body>
    <div class="signup-container">
        <h1>Inscription</h1>

        <?php if (!empty($responseMessage)) : ?>
            <p style="color: <?php echo ($httpCode == 201 || $httpCode == 200) ? 'green' : 'red'; ?>;">
                <?php echo htmlspecialchars($responseMessage); ?>
            </p>
        <?php endif; ?>

        <form action="inscription.php" method="POST" class="signup-form">
            <label for="last-name">Nom</label>
            <input type="text" id="last-name" name="lastName" placeholder="Entrez votre nom" required>

            <label for="first-name">Prénom</label>
            <input type="text" id="first-name" name="firstName" placeholder="Entrez votre prénom" required>

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Créez un mot de passe" required>

            <button type="submit">S'inscrire</button>

            <p class="login-link">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </form>
    </div>
</body>
</html>
