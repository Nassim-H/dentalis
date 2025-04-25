<head>
    <link rel="stylesheet" href="CSS/admin.css">
    <title>Page Admin</title>
</head>
<body>
    <div class="admin-container">
        <h1>Panneau d'administration</h1>

        <!-- Gestion des comptes TODO : modif les droits de l'utilisateur-->
        <section class="admin-section">
            <h2>Gestion des comptes</h2>
            <form>
                <label for="user-email">Email du compte</label>
                <input type="email" id="user-email" name="user-email" placeholder="Entrez l'email du compte" required>

                <button type="submit">Donner les droits administrateurs</button>
                <button type="submit">Donner le statut professionnel</button>
            </form>
        </section>


        <!-- Modifier les membres de l'équipe -->
        <section class="admin-section">
            <h2>Modifier les membres de l'équipe</h2>
            <form>
                <label for="team-member">Nom du membre</label>
                <input type="text" id="team-member" name="team-member" placeholder="Nom du membre">

                <label for="role">Rôle</label>
                <input type="text" id="role" name="role" placeholder="Rôle ou fonction">

                <button type="submit">Mettre à jour</button>
            </form>
        </section>

        <!-- Modifier les informations de contact -->
        <section class="admin-section">
            <h2>Modifier les informations de contact</h2>
            <form>
                <label for="email-contact">Adresse email du cabinet</label>
                <input type="email" id="email-contact" name="email-contact" placeholder="Nouvelle adresse email" required>

                <label for="address">Adresse postale</label>
                <input type="text" id="address" name="address" placeholder="Nouvelle adresse postale" required>

                <button type="submit">Enregistrer les modifications</button>
            </form>
        </section>


        <!-- Modifier les réseaux sociaux -->
        <section class="admin-section">
            <h2>Modifier les réseaux sociaux</h2>
            <form>
                <label for="social-network">Réseau social</label>
                <input type="text" id="social-network" name="social-network" placeholder="Nom du réseau social">

                <label for="social-link">Lien</label>
                <input type="url" id="social-link" name="social-link" placeholder="URL du réseau social">

                <button type="submit">Ajouter ou mettre à jour</button>
            </form>
        </section>
    </div>
</body>
</html>
