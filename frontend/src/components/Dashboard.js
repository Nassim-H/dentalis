import React, { useEffect } from "react";
import { useAuth } from "../contexts/AuthContext";
import { Navigate } from "react-router-dom";

export default function Dashboard() {
  const { user } = useAuth();

  // Pendant le chargement ou token non encore injecté
  if (!user) return <div className="p-4 text-center">Chargement de votre espace...</div>;

  // Redirection selon le rôle
  if (user.admin) return <Navigate to="/admin/dashboard" />;
  if (user.doctor) return <Navigate to="/doctor/dashboard" />;
  return <Navigate to="/patient/dashboard" />;
}
