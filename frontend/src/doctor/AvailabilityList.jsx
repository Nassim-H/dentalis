import React, { useEffect, useState } from "react";
import Calendar from "react-calendar";
import "react-calendar/dist/Calendar.css";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

export default function DoctorAvailabilities() {
  const { token } = useAuth();
  const [selectedDate, setSelectedDate] = useState(new Date());
  const [startHour, setStartHour] = useState("09:00");
  const [endHour, setEndHour] = useState("10:00");
  const [slots, setSlots] = useState([]);
  const [daysWithAvailabilities, setDaysWithAvailabilities] = useState([]);

  const fetchAvailabilities = async () => {
    try {
      const res = await axios.get("http://localhost:8000/api/doctor/availabilities", {
        headers: { Authorization: `Bearer ${token}` },
      });

      const all = res.data.availabilities;

      const uniqueDates = [
        ...new Set(
          all.map((a) => new Date(a.start_datetime).toISOString().split("T")[0])
        ),
      ];
      setDaysWithAvailabilities(uniqueDates);

      const filtered = all.filter(
        (a) => new Date(a.start_datetime).toDateString() === selectedDate.toDateString()
      );
      setSlots(filtered);
    } catch (err) {
      console.error("Erreur récupération des créneaux :", err);
    }
  };

  const handleAddSlot = async () => {
    const localStart = new Date(selectedDate);
    const localEnd = new Date(selectedDate);
    const [sh, sm] = startHour.split(":");
    const [eh, em] = endHour.split(":");

    localStart.setHours(sh, sm);
    localEnd.setHours(eh, em);

    if (localEnd <= localStart) {
      alert("L'heure de fin doit être après l'heure de début.");
      return;
    }

    // Convert to UTC manually (strip local timezone offset)
    const startUTC = new Date(localStart.getTime() - localStart.getTimezoneOffset() * 60000)
      .toISOString()
      .slice(0, 19)
      .replace("T", " ");

    const endUTC = new Date(localEnd.getTime() - localEnd.getTimezoneOffset() * 60000)
      .toISOString()
      .slice(0, 19)
      .replace("T", " ");

    try {
      await axios.post(
        "http://localhost:8000/api/doctor/availabilities",
        {
          start_datetime: startUTC,
          end_datetime: endUTC,
        },
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      );

      await fetchAvailabilities();
    } catch (err) {
      console.error("Erreur ajout de créneau :", err);
    }
  };

  const handleDeleteSlot = async (id) => {
    if (!window.confirm("Supprimer ce créneau ?")) return;

    try {
      await axios.delete(`http://localhost:8000/api/doctor/availabilities/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      await fetchAvailabilities();
    } catch (err) {
      console.error("Erreur suppression :", err);
    }
  };

  useEffect(() => {
    fetchAvailabilities();
  }, [selectedDate]);

  return (
    <div className="p-6 max-w-3xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">Mes disponibilités</h1>

      <Calendar
        value={selectedDate}
        onChange={setSelectedDate}
        className="mb-6 rounded-lg shadow"
        tileClassName={({ date, view }) => {
          if (view === "month") {
            const dateStr = date.toISOString().split("T")[0];
            if (daysWithAvailabilities.includes(dateStr)) {
              return "highlight-available";
            }
          }
          return "";
        }}
      />

      <div className="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label className="block font-medium mb-1">Heure de début</label>
          <input
            type="time"
            value={startHour}
            onChange={(e) => setStartHour(e.target.value)}
            className="border p-2 rounded w-full"
          />
        </div>
        <div>
          <label className="block font-medium mb-1">Heure de fin</label>
          <input
            type="time"
            value={endHour}
            onChange={(e) => setEndHour(e.target.value)}
            className="border p-2 rounded w-full"
          />
        </div>
      </div>

      <button
        onClick={handleAddSlot}
        className="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 mb-6"
      >
        Ajouter ce créneau
      </button>

      <h2 className="text-lg font-semibold mb-2">
        Créneaux du {selectedDate.toLocaleDateString()}
      </h2>
      <ul className="space-y-3">
        {slots.length === 0 ? (
          <p className="text-gray-600">Aucun créneau ce jour-là.</p>
        ) : (
          slots.map((slot) => (
            <li
              key={slot.id}
              className="border p-3 rounded flex justify-between items-center"
            >
              <span>
                {new Date(slot.start_datetime).toLocaleTimeString([], {
                  hour: "2-digit",
                  minute: "2-digit",
                })}{" "}
                -{" "}
                {new Date(slot.end_datetime).toLocaleTimeString([], {
                  hour: "2-digit",
                  minute: "2-digit",
                })}
              </span>
              <button
                onClick={() => handleDeleteSlot(slot.id)}
                className="text-red-600 hover:underline text-sm"
              >
                Supprimer
              </button>
            </li>
          ))
        )}
      </ul>

      <style>{`
        .highlight-available {
          @apply bg-blue-100 text-blue-800 font-semibold rounded-full;
        }
      `}</style>
    </div>
  );
}
