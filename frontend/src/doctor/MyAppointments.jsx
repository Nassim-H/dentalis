  import React, { useEffect, useState } from "react";
  import axios from "axios";
  import { useAuth } from "../contexts/AuthContext";

  export default function DoctorAppointments() {
    const { token } = useAuth();
    const [appointments, setAppointments] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchAppointments = async () => {
      try {
        const res = await axios.get("http://localhost:8000/api/doctor/appointments", {
          headers: { Authorization: `Bearer ${token}` },
        });
        setAppointments(res.data.appointments);
      } catch (err) {
        console.error("Erreur chargement RDV médecin :", err);
      } finally {
        setLoading(false);
      }
    };

    useEffect(() => {
      fetchAppointments();
    }, []);

    const formatDate = (iso) => {
      const date = new Date(iso);
      return date.toLocaleDateString() + " à " + date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    };

    if (loading) return <div className="p-4">Chargement des rendez-vous...</div>;

    if (appointments.length === 0) {
      return (
        <div className="p-6 max-w-3xl mx-auto text-center bg-white rounded-lg shadow">
          <h2 className="text-2xl font-semibold text-gray-800 mb-2">Aucun rendez-vous à venir</h2>
          <p className="text-gray-600">Vous n’avez aucun rendez-vous programmé pour l’instant.</p>
        </div>
      );
    }

    return (
      <div className="p-6 max-w-3xl mx-auto">
        <h1 className="text-2xl font-bold mb-4">Mes rendez-vous</h1>
        <ul className="space-y-3">
          {appointments.map((rdv) => (
            <li
              key={rdv.id}
              className="border rounded p-4 flex justify-between items-center bg-white shadow-sm"
            >
              <div>
                <p className="font-semibold text-blue-800">{formatDate(rdv.date)}</p>
                <p className="text-gray-700">{rdv.description}</p>
                <p className="text-sm text-gray-500">
                  Patient : {rdv.client?.first_name} {rdv.client?.last_name}
                </p>
              </div>
              {/* 🟡 Bonus futur : bouton "Annuler / Terminer" */}
            </li>
          ))}
        </ul>
      </div>
    );
  }
