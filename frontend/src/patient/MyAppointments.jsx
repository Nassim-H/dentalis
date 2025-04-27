import React, { useEffect, useState } from "react";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

export default function MyAppointments() {
  const { token } = useAuth();
  const [appointments, setAppointments] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchAppointments = async () => {
    try {
      const res = await axios.get("http://localhost:8000/api/patient/appointments", {
        headers: { Authorization: `Bearer ${token}` },
      });
      setAppointments(res.data.appointments);
    } catch (err) {
      console.error("Erreur chargement RDV :", err);
    } finally {
      setLoading(false);
    }
  };

  const cancelAppointment = async (id) => {
    if (!window.confirm("Voulez-vous vraiment annuler ce rendez-vous ?")) return;

    try {
      await axios.delete(`http://localhost:8000/api/patient/appointments/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      fetchAppointments(); // recharge après suppression
    } catch (err) {
      console.error("Erreur suppression RDV :", err);
      alert("Impossible d’annuler le rendez-vous.");
    }
  };

  useEffect(() => {
    fetchAppointments();
  }, []);

  const formatDate = (iso) => {
    const date = new Date(iso);
    return date.toLocaleDateString() + " à " + date.toLocaleTimeString();
  };

  if (loading) return <div className="p-4">Chargement des rendez-vous...</div>;

  if (appointments.length === 0) {
    return (
      <div className="p-20 mt-20 max-w-3xl mx-auto text-center bg-white rounded-lg shadow">
        <h2 className="text-2xl font-semibold text-gray-800 mb-2">
          Aucun rendez-vous trouvé 🕐
        </h2>
        <p className="text-gray-600 mb-6">
          Vous n’avez pas encore pris de rendez-vous avec un médecin.
        </p>
        <a
          href="/rdv/new"
          className="inline-block bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Prendre un rendez-vous
        </a>
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
            className="border rounded p-4 flex justify-between items-center"
          >
            <div>
              <p className="font-semibold">{formatDate(rdv.date)}</p>
              <p className="text-gray-600">{rdv.description}</p>
              <p className="text-sm text-gray-500">
                Avec le Dr {rdv.doctor?.first_name} {rdv.doctor?.last_name}
              </p>
            </div>
            <button
              onClick={() => cancelAppointment(rdv.id)}
              className="text-red-600 hover:underline text-sm"
            >
              Annuler
            </button>
          </li>
        ))}
      </ul>
    </div>
  );
}
