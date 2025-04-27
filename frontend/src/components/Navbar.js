import { Link, useNavigate } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";

const Navbar = () => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = async () => {
    await logout();
    navigate("/login");
  };

  const getDashboardLink = () => {
    if (!user) return "/";
    if (user.admin) return "/admin/dashboard";
    if (user.doctor) return "/doctor/dashboard";
    return "/patient/dashboard";
  };

  return (
    <nav className="bg-white shadow-md py-4 px-8 flex justify-between items-center">
      <Link to="/" className="text-primary text-2xl font-bold">Farid Cabinet</Link>

      <div className="flex items-center gap-6">
        <Link to="/services" className="text-dark hover:text-primary">Nos Services</Link>
        <Link to="/team" className="text-dark hover:text-primary">Notre Équipe</Link>
        <Link to="/contact" className="text-dark hover:text-primary">Nous Contacter</Link>
      </div>

      {!user ? (
        <div>
          <Link to="/login" className="text-dark px-4 hover:text-primary">Connexion</Link>
          <Link to="/register" className="bg-primary text-white px-4 py-2 rounded-lg ml-2 hover:bg-blue-600">
            Inscription
          </Link>
        </div>
      ) : (
        <div className="flex items-center gap-4">
          <Link to={getDashboardLink()} className="text-dark hover:text-primary">
            Dashboard
          </Link>
          <span className="text-sm text-gray-600">
            {user.first_name} {user.last_name} ({user.admin ? "Admin" : user.doctor ? "Médecin" : "Patient"})
          </span>
          <button
            onClick={handleLogout}
            className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
          >
            Déconnexion
          </button>
        </div>
      )}
    </nav>
  );
};

export default Navbar;
