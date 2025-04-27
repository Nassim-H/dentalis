import React, { useEffect, useState } from "react";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

export default function AdminDashboard() {
  const { token } = useAuth();
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  const fetchUsers = async () => {
    console.log("AdminDashboard mounted");
    
    try {
      const res = await axios.get("http://localhost:8000/api/users", {
        headers: { Authorization: `Bearer ${token}` },
      });
      setUsers(res.data.users);
    } catch (error) {
      console.error("Erreur chargement utilisateurs :", error);
    } finally {
      setLoading(false);
    }
  };

  const toggleDoctor = async (userId, isDoctor) => {
    try {
      await axios.patch(`http://localhost:8000/api/users/${userId}/set-doctor`, {
        is_doctor: !isDoctor,
      }, {
        headers: { Authorization: `Bearer ${token}` },
      });
      fetchUsers(); // refresh list
    } catch (err) {
      console.error("Erreur mise à jour rôle médecin :", err);
    }
  };

  const toggleAdmin = async (userId, isAdmin) => {
    try {
      await axios.patch(`http://localhost:8000/api/users/${userId}/set-admin`, {
        is_admin: !isAdmin,
      }, {
        headers: { Authorization: `Bearer ${token}` },
      });
      fetchUsers(); // refresh
    } catch (err) {
      console.error("Erreur mise à jour rôle admin :", err);
    }
  };
  

  useEffect(() => {
    fetchUsers();
  }, []);

  if (loading) return <div className="p-4">Chargement...</div>;

  return (
    <div className="p-6 max-w-6xl mx-auto">
      <h1 className="text-3xl font-bold mb-6 text-center text-primary">Espace Administrateur</h1>
  
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {users.map(user => (
          <div key={user.id} className="bg-white rounded-xl shadow-md p-5 border border-gray-200">
            <h2 className="text-xl font-semibold text-gray-800 mb-1">
              {user.first_name} {user.last_name}
            </h2>
            <p className="text-sm text-gray-600 mb-2">{user.email}</p>
  
            <p className="mb-3">
              <span className={`inline-block px-2 py-1 text-xs rounded-full font-medium
                ${user.admin ? 'bg-purple-100 text-purple-800' :
                  user.doctor ? 'bg-blue-100 text-blue-800' :
                  'bg-gray-100 text-gray-800'}`}>
                {user.admin ? 'Admin' : user.doctor ? 'Médecin' : 'Patient'}
              </span>
            </p>
  
            <div className="flex flex-col gap-2">
              <button
                onClick={() => toggleDoctor(user.id, user.doctor)}
                className="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md text-sm"
              >
                {user.doctor ? "Retirer rôle médecin" : "Attribuer rôle médecin"}
              </button>
  
              {user.id !== 2 && (
                <button
                  onClick={() => toggleAdmin(user.id, user.admin)}
                  className="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-md text-sm"
                >
                  {user.admin ? "Retirer rôle admin" : "Attribuer rôle admin"}
                </button>
              )}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}  