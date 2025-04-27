import React from "react";
import { useAuth } from "../contexts/AuthContext";
import { Link } from "react-router-dom";

export default function DoctorDashboard() {
  const { user } = useAuth();

  if (!user) return null;

  return (
    <div className="p-6 max-w-4xl mx-auto">
      <h1 className="text-2xl font-bold mb-2">Bienvenue Dr {user.last_name} 👨‍⚕️</h1>
      <p className="text-gray-600 mb-6">Voici votre espace professionnel.</p>

      <div className="space-y-4">
        <div className="border p-4 rounded-lg shadow hover:shadow-md transition">
          <h2 className="text-lg font-semibold mb-2">Mes disponibilités</h2>
          <p className="mb-2 text-gray-700">Ajoutez ou supprimez vos créneaux de rendez-vous.</p>
          <Link to="/doctor/availabilities" className="text-blue-600 font-medium hover:underline">
            Gérer mes créneaux →
          </Link>
        </div>

        <div className="border p-4 rounded-lg shadow hover:shadow-md transition">
          <h2 className="text-lg font-semibold mb-2">Mes rendez-vous reçus</h2>
          <p className="mb-2 text-gray-700">Consultez la liste des rendez-vous planifiés avec vous.</p>
          <Link to="/doctor/appointments" className="text-blue-600 font-medium hover:underline">
            Voir mes rendez-vous →
          </Link>
        </div>
      </div>
    </div>
  );
}
