import React from "react";
import { useAuth } from "../contexts/AuthContext";
import { Link } from "react-router-dom";

export default function PatientDashboard() {
  const { user } = useAuth();

  if (!user) return null;

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <h1 className="text-2xl font-bold mb-2">Bonjour {user.first_name} 👋</h1>
      <p className="text-gray-600 mb-6">Bienvenue dans votre espace patient.</p>

      <div className="space-y-4">
        <div className="border p-4 rounded-lg shadow hover:shadow-md transition">
          <h2 className="text-lg font-semibold mb-2">Prendre un rendez-vous</h2>
          <p className="mb-2 text-gray-700">Consultez les créneaux disponibles et prenez rendez-vous avec un médecin.</p>
          <Link to="/rdv/new" className="text-blue-600 font-medium hover:underline">
            Réserver un créneau →
          </Link>
        </div>

        <div className="border p-4 rounded-lg shadow hover:shadow-md transition">
          <h2 className="text-lg font-semibold mb-2">Mes rendez-vous</h2>
          <p className="mb-2 text-gray-700">Consultez vos rendez-vous passés et à venir.</p>
          <Link to="/rdv/mine" className="text-blue-600 font-medium hover:underline">
            Voir mes rendez-vous →
          </Link>
        </div>
      </div>
    </div>
  );
}
