const rdvs = {
    "2025-02-05": ["Consultation avec Docteur A - Jean Dupont, 45 ans"],
    "2025-02-08": ["Soins dentaires avec Docteur B - Marie Curie, 37 ans"],
    "2025-02-10": ["Orthodontie avec Docteur A - Paul Martin, 22 ans", "Consultation avec Docteur B - Sophie Lemaitre, 30 ans"]
};

let currentDate = new Date();
let selectedDate = null;
let selectedRdvIndex = null;

// Fonction pour afficher la modale
function openEditModal(date, rdvIndex) {
    selectedDate = date;
    selectedRdvIndex = rdvIndex;

    if (selectedDate in rdvs && rdvs[selectedDate][selectedRdvIndex]) {
        document.getElementById("editRdvName").value = rdvs[date][rdvIndex];
        document.getElementById("editModal").style.display = "flex";
    }
}

// Fermer la modale
document.querySelector(".close").addEventListener("click", () => {
    document.getElementById("editModal").style.display = "none";
});

// Enregistrer les modifications
document.getElementById("saveChanges").addEventListener("click", () => {
    let newName = document.getElementById("editRdvName").value;
    if (selectedDate && selectedRdvIndex !== null) {
        rdvs[selectedDate][selectedRdvIndex] = newName;
        renderCalendar();
        document.getElementById("editModal").style.display = "none";
    }
});

// Supprimer le RDV
document.getElementById("deleteRdv").addEventListener("click", () => {
    if (selectedDate && selectedRdvIndex !== null) {
        rdvs[selectedDate].splice(selectedRdvIndex, 1);
        if (rdvs[selectedDate].length === 0) {
            delete rdvs[selectedDate]; // Supprime la date si elle n'a plus de RDV
        }
        renderCalendar();
        document.getElementById("editModal").style.display = "none";
    }
});

// Fonction pour générer le calendrier
function renderCalendar() {
    const monthYear = document.getElementById("monthYear");
    const calendarBody = document.getElementById("calendar-body");
    calendarBody.innerHTML = "";

    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();

    monthYear.innerText = new Intl.DateTimeFormat('fr-FR', { month: 'long', year: 'numeric' }).format(currentDate);

    const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let dayCount = 1;
    for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr");
        for (let j = 0; j < 7; j++) {
            let cell = document.createElement("td");
            if ((i === 0 && j < firstDay) || dayCount > daysInMonth) {
                cell.innerHTML = "";
            } else {
                let dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(dayCount).padStart(2, '0')}`;
                cell.innerHTML = dayCount;
                if (rdvs[dateStr]) {
                    rdvs[dateStr].forEach((rdv, index) => {
                        let rdvEl = document.createElement("span");
                        rdvEl.className = "rdv";
                        rdvEl.innerText = `• ${rdv}`;
                        rdvEl.addEventListener("click", (e) => {
                            e.stopPropagation();
                            openEditModal(dateStr, index);
                        });
                        cell.appendChild(rdvEl);
                    });
                }
                dayCount++;
            }
            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }
}

// Gestion du changement de mois
function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    currentDate.setDate(1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    currentDate.setDate(1);
    renderCalendar();
}

// Lancement du calendrier au chargement de la page
document.addEventListener("DOMContentLoaded", renderCalendar);
