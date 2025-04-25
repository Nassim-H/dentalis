<?php
$response = "";  // Variable pour stocker la réponse de l'API

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service = $_POST['service'];
    $date = $_POST['date'];
    $medecin = $_POST['medecin'];
    $details = $_POST['details'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];

    // Préparer les données à envoyer à l'API
    $postData = [
        'service' => $service,
        'date' => $date,
        'medecin' => $medecin,
        'details' => $details,
        'nom' => $nom,
        'prenom' => $prenom,
        'age' => $age
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

<head>
    <title>Prise de rendez-vous</title>
    <link rel="stylesheet" href="CSS/gestionRdv1.css">
</head>
<body>
    <div class="container">
        <!-- Section prise de rendez-vous -->
        <section class="appointment-section">
            <h1>Prendre rendez-vous</h1>
            <form action='gestionRdv1.php' method='POST' class="appointment-form">
                <div class="form-group">
                    <label for="service">Sélection service</label>
                    <select id="service" name="service">
                        <option value="consultation">Consultation</option>
                        <option value="soins">Soins dentaires</option>
                        <option value="orthodontie">Orthodontie</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date et heure</label>
                    <input type="datetime-local" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="medecin">Sélection médecin</label>
                    <select id="medecin" name="medecin">
                        <option value="docteur-a">Docteur A</option>
                        <option value="docteur-b">Docteur B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="details">Détails</label>
                    <textarea id="details" name="details" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom">
                </div>
                <div class="form-group">
                    <label for="age">Âge</label>
                    <input type="number" id="age" name="age">
                </div>
                <button type="submit" class="btn-primary">Confirmer</button>
            </form>
        </section>

        <!-- Section liste des rendez-vous -->
        <section class="appointment-list">
            <h1>Liste des rendez-vous</h1>
            <ul>
                <li>
                    Rendez-vous (date)
                    <button class="btn-secondary">Modifier</button>
                </li>
                <li>
                    Rendez-vous (date)
                    <button class="btn-secondary">Modifier</button>
                </li>
            </ul>
        </section>
    </div>
</body>
</html>
