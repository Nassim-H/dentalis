

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
    	rdvList = {
    	"2025-3-4": ["Dentiste 14h"],
    	"2025-2-13": ["Médecin 10h", "Ophtalmo 16h"],
    	"2025-2-26": ["Vaccin 9h"],
	};
	loadCalendar();

	</script>

</body>
</html>
