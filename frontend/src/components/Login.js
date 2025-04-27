import React from "react";
import { useAuth } from "../contexts/AuthContext";
import { Link, useNavigate  } from "react-router-dom";

const Login = () => {
  const { login } = useAuth();
  const navigate = useNavigate(); // 🔥 Ajout ici



  const handleSubmit = async (e) => {
    e.preventDefault();
    const email = e.target.email.value;
    const password = e.target.password.value;
    await login(email, password);
    navigate("/dashboard"); // Redirection vers le tableau de bord après connexion réussie
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-secondary">
      <div className="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 className="text-2xl font-bold text-primary text-center">Connexion</h2>
        <form onSubmit={handleSubmit} className="mt-4 space-y-4">
          <div>
            <label className="block text-dark font-medium">Email</label>
            <input type="email" name="email" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <div>
            <label className="block text-dark font-medium">Mot de passe</label>
            <input type="password" name="password" className="w-full p-2 border rounded-lg focus:ring-2 focus:ring-primary" required />
          </div>
          <button type="submit" className="w-full bg-primary text-white py-2 rounded-lg shadow-md hover:bg-blue-600 transition">
            Se connecter
          </button>
        </form>
        <p className="mt-4 text-center text-dark">
          Pas encore de compte ? <Link to="/register" className="text-primary font-bold hover:underline">Inscrivez-vous</Link>
        </p>
      </div>
    </div>
  );
};

export default Login;
