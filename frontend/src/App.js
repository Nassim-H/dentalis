import React, { createContext, useContext, useEffect, useState } from "react";
import { BrowserRouter as Router, Route, Routes, Navigate } from "react-router-dom";
import axios from "axios";
import Login from "./components/Login";
import Register from "./components/Register";
import Dashboard from "./components/Dashboard";
import { AuthProvider } from "./contexts/AuthContext";
import Navbar from "./components/Navbar";
import PrivateRoute from "./components/PrivateRoute";
import AdminDashboard from "./admin/Dashboard";
import DoctorDashboard from "./doctor/Dashboard";
import PatientDashboard from "./patient/Dashboard";
import Footer from "./components/Footer";
import AvailabilityList from "./doctor/AvailabilityList";
import BookAppointment from "./patient/BookAppointment";
import MyAppointments from "./patient/MyAppointments";
import DoctorAppointments from "./doctor/MyAppointments";
import Services from "./pages/Services";
import Team from "./pages/Team";
import Contact from "./pages/Contact";

const App = () => {
  return (
    <AuthProvider>
      <Router>
      <div className="min-h-screen flex flex-col">

          <Navbar />
          <main className="flex-grow">
          <Routes>
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/" element={<Navigate to="/login" />} />

            {/* Route qui redirige en fonction du rôle */}
            <Route path="/dashboard" element={<PrivateRoute><Dashboard /></PrivateRoute>} />

            {/* Routes par rôle */}
            <Route path="/admin/dashboard" element={<PrivateRoute><AdminDashboard /></PrivateRoute>} />
            <Route path="/doctor/dashboard" element={<PrivateRoute><DoctorDashboard /></PrivateRoute>} />
            <Route path="/patient/dashboard" element={<PrivateRoute><PatientDashboard /></PrivateRoute>} />
            <Route path="/doctor/availabilities" element={<PrivateRoute><AvailabilityList /></PrivateRoute>} />
            <Route path="/doctor/appointments" element={<PrivateRoute><DoctorAppointments /></PrivateRoute>} />
            <Route path="/rdv/new" element={<PrivateRoute><BookAppointment /></PrivateRoute>} />
            <Route path="/rdv/mine" element={<PrivateRoute><MyAppointments /></PrivateRoute>} />

            <Route path="services" element={<Services />} />
            <Route path="team" element={<Team />} />
            <Route path="contact" element={<Contact />} />

            </Routes>
            </main>
          
        <Footer />
        </div>
      </Router>
    </AuthProvider>
  );
};

export default App;