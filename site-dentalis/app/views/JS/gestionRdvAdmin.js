let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let selectedRdv = null;

const monthYear = document.getElementById("monthYear");
const calendarBody = document.getElementById("calendar-body");

const editModal = document.getElementById("editModal");
const editRdvName = document.getElementById("editRdvName");

// Stockage des RDV
let rdvList = {};

// Charger le calendrier
function loadCalendar() {
    monthYear.textContent = new Date(currentYear, currentMonth).toLocaleString('fr-FR', { month: 'long', year: 'numeric' });
    
    calendarBody.innerHTML = "";
    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1; // Adapter le décalage de la semaine
    
    let totalDays = new Date(currentYear, currentMonth + 1, 0).getDate();
    let row = document.createElement("tr");

    for (let i = 0; i < firstDay; i++) {
        row.appendChild(document.createElement("td"));
    }

    for (let day = 1; day <= totalDays; day++) {
        let cell = document.createElement("td");
        cell.textContent = day;

        let dateKey = `${currentYear}-${currentMonth + 1}-${day}`;
        
        if (rdvList[dateKey]) {
            rdvList[dateKey].forEach(rdv => {
                let rdvEl = document.createElement("span");
                rdvEl.classList.add("rdv");
                rdvEl.textContent = `• ${rdv}`;
                rdvEl.onclick = () => openEditModal(dateKey, rdv);
                cell.appendChild(rdvEl);
            });
        }

        row.appendChild(cell);
        
        if ((firstDay + day) % 7 === 0) {
            calendarBody.appendChild(row);
            row = document.createElement("tr");
        }
    }
    
    calendarBody.appendChild(row);
}

// Changer de mois
function prevMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    loadCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    loadCalendar();
}

// Ajouter un RDV
function addRdv(date, name) {
    if (!rdvList[date]) rdvList[date] = [];
    rdvList[date].push(name);
    loadCalendar();
}

// Ouvrir la modale d'édition
function openEditModal(date, rdv) {
    selectedRdv = { date, rdv };
    editRdvName.value = rdv;
    editModal.style.display = "flex";
}

// Fermer la modale
function closeModal() {
    editModal.style.display = "none";
}

// Sauvegarder les modifications
function saveChanges() {
    if (selectedRdv) {
        let { date, rdv } = selectedRdv;
        let index = rdvList[date].indexOf(rdv);
        if (index !== -1) {
            rdvList[date][index] = editRdvName.value;
            loadCalendar();
        }
    }
    closeModal();
}

// Supprimer un RDV
function deleteRdv() {
    if (selectedRdv) {
        let { date, rdv } = selectedRdv;
        rdvList[date] = rdvList[date].filter(item => item !== rdv);
        if (rdvList[date].length === 0) delete rdvList[date];
        loadCalendar();
    }
    closeModal();
}

// Initialisation
// Ajout de RDV par défaut


loadCalendar();
