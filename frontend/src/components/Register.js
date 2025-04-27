import React from "react";
import { useAuth } from "../contexts/AuthContext";
import { Link } from "react-router-dom";
import axios from "axios"; // ✅ Ajout de l'import
import { useNavigate } from "react-router-dom";
const Register = () => {
  const { register } = useAuth();
  const navigate = useNavigate(); // ✅ Hook pour la redirection

  const handleSubmit = async (e) => {
    e.preventDefault();
    const data = {
        lastName: e.target.lastName.value,
        firstName: e.target.firstName.value,
        email: e.target.email.value,
        password: e.target.password.value,
    };

    console.log("Données envoyées :", data);

    try {
        const response = await fetch("http://localhost:8000/api/auth/users/register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        console.log("Réponse de l'API :", result);
        navigate("/patient/dashboard");
    } catch (error) {
        console.error("Erreur API :", error);
    }
};


  return (
    <div className="min-h-screen flex items-center justify-center bg-secondary">
      <div className="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 className="text-2xl font-bold text-primary text-center">Inscription</h2>
        <form onSubmit={handleSubmit} className="mt-4 space-y-4">
          <div>
            <label className="block text-dark font-medium">Prénom</label>
            <input type="text" name="firstName" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <div>
            <label className="block text-dark font-medium">Nom</label>
            <input type="text" name="lastName" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <div>
            <label className="block text-dark font-medium">Email</label>
            <input type="email" name="email" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <div>
            <label className="block text-dark font-medium">Mot de passe</label>
            <input type="password" name="password" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <button type="submit" className="w-full bg-primary text-white py-2 rounded-lg shadow-md hover:bg-blue-600 transition">
            S'inscrire
          </button>
        </form>
      </div>
    </div>
  );
};

export default Register;
