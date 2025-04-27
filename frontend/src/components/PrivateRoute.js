import { useAuth } from "../contexts/AuthContext";
import { Navigate } from "react-router-dom";

const PrivateRoute = ({ children }) => {
  const { user, token } = useAuth();

  // On attend que AuthContext charge le user
  if (token && !user) {
    return <p className="p-4">Chargement de votre session...</p>;
  }

  if (!token || !user) {
    return <Navigate to="/login" />;
  }

  return children;
};

export default PrivateRoute;
