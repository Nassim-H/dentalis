<?php
$response = "";  // Variable pour stocker la réponse de l'API

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer les données à envoyer à l'API
    $postData = [
        'lastName' => $lastName,
        'firstName' => $firstName,
        'email' => $email,
        'password' => $password
    ];

    // Utiliser cURL pour envoyer une requête POST à l'API
    $ch = curl_init('http://127.0.0.1:8000/api/users/register'); // Ajuste cette URL si nécessaire
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);

    // Exécuter la requête
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $response = 'Erreur de requête: ' . curl_error($ch);
    }
    curl_close($ch);

    // La réponse peut être traitée plus loin ou affichée directement
    if ($response) {
        $response = json_decode($response, true);  // Assumer que la réponse est en JSON
    }
}
?>
<head>
    <link rel="stylesheet" href="CSS/inscription.css">
    <title>Inscription</title>
</head>

<body>
    <div class="signup-container">
        <h1>Inscription</h1>
        <form action='inscription.php' method='POST' class="signup-form">
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
                Déjà un compte ? <a href="#">Se connecter</a>
            </p>
        </form>
    </div>
</body>
</html>
