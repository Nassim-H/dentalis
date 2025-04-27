import React, { useEffect, useState } from "react";
import Calendar from "react-calendar";
import 'react-calendar/dist/Calendar.css';
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

export default function BookAppointment() {
  const { token } = useAuth();
  const [date, setDate] = useState(new Date());
  const [timeSlots, setTimeSlots] = useState([]);
  const [doctors, setDoctors] = useState([]);
  const [selectedDoctorId, setSelectedDoctorId] = useState(null);

  const fetchDoctors = async () => {
    try {
      const res = await axios.get("http://localhost:8000/api/doctors", {
        headers: { Authorization: `Bearer ${token}` }, // optionnel si route publique
      });
      setDoctors(res.data.doctors);
    } catch (err) {
      console.error("Erreur chargement médecins :", err);
    }
  };
  

  const fetchAvailableTimeSlots = async (selectedDate) => {
    try {
      const [availRes, apptRes] = await Promise.all([
        axios.get(`http://localhost:8000/api/doctors/${selectedDoctorId}/availabilities`, {
          headers: { Authorization: `Bearer ${token}` },
        }),
        axios.get(`http://localhost:8000/api/doctors/${selectedDoctorId}/appointments`, {
          headers: { Authorization: `Bearer ${token}` },
        })
        
      ]);

      const availabilities = availRes.data.availabilities;
      const appointments = apptRes.data.appointments.map((appt) => {
        const start = new Date(appt.date);
        const end = new Date(start.getTime() + appt.duration * 60000);
        return { start, end };
      });

      const slots = [];

      for (let avail of availabilities) {
        const start = new Date(avail.start_datetime);
        const end = new Date(avail.end_datetime);

        while (start < end) {
          if (start.toDateString() === selectedDate.toDateString()) {
            const slotStart = new Date(start);
            const slotEnd = new Date(start.getTime() + 30 * 60000);

            const isTaken = appointments.some(
              (appt) =>
                slotStart < appt.end && slotEnd > appt.start
            );

            if (!isTaken) {
              slots.push(new Date(slotStart));
            }
          }
          start.setMinutes(start.getMinutes() + 30);
        }
      }

      setTimeSlots(slots);
    } catch (err) {
      console.error("Erreur chargement créneaux :", err);
    }
  };

  const handleTakeAppointment = async (datetime) => {
    const utcDate = new Date(datetime.getTime() - datetime.getTimezoneOffset() * 60000);
    const formattedDate = utcDate.toISOString().slice(0, 19).replace("T", " ");

    try {
      await axios.post("http://localhost:8000/api/patient/appointments", {
        doctor_id: selectedDoctorId,
        date: formattedDate,
        duration: 30,
        description: "Consultation",
      }, {
        headers: { Authorization: `Bearer ${token}` },
      });

      alert("RDV réservé !");
      fetchAvailableTimeSlots(date);
    } catch (err) {
      console.error("Erreur réservation :", err.response?.data || err.message);
      alert("Erreur lors de la prise de RDV.");
    }
  };

  useEffect(() => {
    fetchDoctors();
  }, []);

  useEffect(() => {
    if (selectedDoctorId) {
      fetchAvailableTimeSlots(date);
    }
  }, [date, selectedDoctorId]);

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <h1 className="text-2xl font-bold mb-4">Prendre un rendez-vous</h1>

      <div className="mb-4">
        <label className="block mb-1 font-medium">Choisir un médecin</label>
        <select
          value={selectedDoctorId || ""}
          onChange={(e) => setSelectedDoctorId(e.target.value)}
          className="border p-2 rounded w-full"
        >
          <option value="">-- Sélectionnez un médecin --</option>
          {doctors.map((doc) => (
            <option key={doc.id} value={doc.id}>
              Dr {doc.first_name} {doc.last_name}
            </option>
          ))}
        </select>
      </div>

      {selectedDoctorId && (
        <>
          <Calendar value={date} onChange={setDate} className="mb-6" />

          <h2 className="text-lg font-semibold mb-2">Créneaux disponibles</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
            {timeSlots.length > 0 ? (
              timeSlots.map((slot, idx) => (
                <button
                  key={idx}
                  onClick={() => handleTakeAppointment(slot)}
                  className="bg-primary text-white px-3 py-2 rounded hover:bg-blue-700 text-sm"
                >
                  {slot.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                </button>
              ))
            ) : (
              <p className="col-span-full text-gray-500">Aucun créneau dispo ce jour.</p>
            )}
          </div>
        </>
      )}
    </div>
  );
}
