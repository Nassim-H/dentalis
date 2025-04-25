<?php
// Récupération des rendez-vous depuis l'API
$apiUrl = 'http://127.0.0.1:8000/api/appointments/list'; // Ajuste cette URL si nécessaire

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$appointments = json_decode($response, true);
?>

<head>
    <title>Calendrier des Rendez-vous</title>
    <link rel="stylesheet" href="CSS/gestionRdvAdmin.css">
</head>
<body>
    <div class="container">
        <!-- Calendrier -->
        <section class="calendar-container">
            <div class="calendar-header">
                <button onclick="prevMonth()">&#9664;</button>
                <h2 id="monthYear"></h2>
                <button onclick="nextMonth()">&#9654;</button>
            </div>
            <table class="calendar">
                <thead>
                    <tr>
                        <th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th>
                        <th>Vendredi</th><th>Samedi</th><th>Dimanche</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Les jours seront générés ici -->
                </tbody>
            </table>
        </section>
    </div>

    <!-- Fenêtre modale pour gérer un RDV -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Modifier le rendez-vous</h2>
            <label>Nouveau nom :</label>
            <input type="text" id="editRdvName">
            <button onclick="saveChanges()">Enregistrer</button>
            <button onclick="deleteRdv()">Supprimer</button>
        </div>
    </div>

    <script src="JS/gestionRdvAdmin.js"></script>
    <script>
        let rdvList = {};
        <?php
        if (!empty($appointments)) {
            echo "rdvList = " . json_encode($appointments) . ";";
        }
        ?>
        loadCalendar();
    </script>
</body>
</html>
