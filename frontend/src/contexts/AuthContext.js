import React, { createContext, useContext, useEffect, useState } from "react";
import axios from "axios";

const API_BASE_URL = "http://127.0.0.1:8000/api";
const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [token, setToken] = useState(localStorage.getItem("token"));

  useEffect(() => {
    if (token) {
      axios.defaults.headers.common["Authorization"] = `Bearer ${token}`; // <-- AJOUT ICI
      axios
        .get(`${API_BASE_URL}/auth/me`, {
          headers: { Authorization: `Bearer ${token}` },
        })
        .then((res) => setUser(res.data))
        .catch(() => logout());
    }
  }, [token]);

  const login = async (email, password) => {
    const res = await axios.post(`${API_BASE_URL}/auth/login`, { email, password });
    setToken(res.data.token);
    localStorage.setItem("token", res.data.token);
    axios.defaults.headers.common["Authorization"] = `Bearer ${res.data.token}`;
    setUser(res.data.user);
  };

  const register = async (data) => {
    await axios.post(`${API_BASE_URL}/auth/register`, data);
  };

  const logout = () => {
    axios.post(`${API_BASE_URL}/auth/logout`, {}, {
      headers: { Authorization: `Bearer ${token}` },
    });
    setUser(null);
    setToken(null);
    localStorage.removeItem("token");
  };

  return (
    <AuthContext.Provider value={{ user, token, login, register, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
