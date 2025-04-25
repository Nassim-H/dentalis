<?php
$response = "";  // Variable pour stocker la réponse de l'API

if (\$_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = \$_POST['email'];
    $password = \$_POST['password'];

    // Préparer les données à envoyer à l'API
    $postData = [
        'email' => $email,
        'password' => $password
    ];

    // Utiliser cURL pour envoyer une requête POST à l'API
    $ch = curl_init('http://127.0.0.1:8000/api/users/login'); // Ajuste cette URL si nécessaire
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
    <link rel="stylesheet" href="./CSS/connexion.css">
    <title>Connexion</title>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <form class="login-form" method="POST">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>

            <p class="forgot-password">
                <a href="#">Mot de passe oublié ?</a>
            </p>
            
            <p class="register-link">
                Pas encore inscrit ? <a href="#">Créer un compte</a>
            </p>
        </form>
    </div>
</body>
</html>
