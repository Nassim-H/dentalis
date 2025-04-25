🚀 Lancement du projet Dentalis (Laravel + React)
🔁 1. Cloner le dépôt
bash
Copy
Edit
git clone https://github.com/Nassim-H/APIDENTALIS.git
cd APIDENTALIS
📂 2. Lancer le backend Laravel
bash
Copy
Edit
cd api-dentalis
composer install         # Installer les dépendances PHP

# essaie d'abord sans
# Créer la base de données dans MySQL si ce n’est pas déjà fait
# (par exemple via phpMyAdmin ou MySQL CLI)

php artisan migrate      # Lancer les migrations

php artisan serve        # Lancer le serveur Laravel
🟡 L’API sera dispo sur : http://localhost:8000

💻 3. Lancer le frontend React
Ouvre un 2e terminal :

bash
Copy
Edit
cd front-dentalis
npm install         # Installer les packages React
npm run dev         # Lancer le serveur de développement
🟢 L’interface web sera dispo sur : http://localhost:3000
