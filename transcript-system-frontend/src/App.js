// src/App.js
import './App.css';
import { BrowserRouter as Router, Routes, Route, useLocation } from "react-router-dom";
import LoginPage from "./pages/LoginPage";
import TranscriptPage from "./pages/TranscriptPage";
import ProtectedRoute from "./components/ProtectedRoute";
import AdminRoute from './components/AdminRoute';
import Navbar from "./components/Navbar";
import AdminPage from './pages/AdminPage';
import AdminDashboard from "./pages/AdminDashboard";
import DepartmentPage from './pages/DepartmentPage';
import ProfilePage from "./pages/ProfilePage";
import ChangePasswordPage from "./pages/ChangePasswordPage";

function AppContent() {
  const location = useLocation();
  
  return (
    <>
      {/* Show Navbar only if user is NOT on login page */}
      {location.pathname !== "/" && <Navbar />}

      <Routes>
        {/* Public Route */}
        <Route path="/" element={<LoginPage />} />

        {/* Staff and Admin accessible route */}
        <Route
          path="/transcript"
          element={
            <ProtectedRoute>
              <TranscriptPage />
            </ProtectedRoute>
          }
        />

        {/* Admin only accessible route */}
        <Route
          path="/admin"
          element={
            <AdminRoute>
              <AdminPage />
            </AdminRoute>
          }
        />
        <Route
            path="/admin/dashboard"
            element={
              <AdminRoute>
                <AdminDashboard />
    </AdminRoute>
  }
/>
      <Route
        path="/admin/departments"
        element={
          <AdminRoute>
            <DepartmentPage />
          </AdminRoute>
        }
/>

<Route path="/profile" element={<ProfilePage />} />
<Route path="/change-password" element={<ChangePasswordPage />} />
      </Routes>
    </>
  );
}

function App() {
  return (
    <Router>
      <AppContent />
    </Router>
  );
}

export default App;
