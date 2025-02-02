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
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="accueil.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="lastName">Nom:</label>
        <input type="text" id="lastName" name="lastName" required><br><br>

        <label for="firstName">Prénom:</label>
        <input type="text" id="firstName" name="firstName" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <?php if (!empty($response)): ?>
        <h3>Réponse de l'API :</h3>
        <pre><?php print_r($response); ?></pre>
    <?php endif; ?>
</body>
</html>
