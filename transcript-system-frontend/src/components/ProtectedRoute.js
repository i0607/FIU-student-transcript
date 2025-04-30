import { Navigate } from "react-router-dom";

const ProtectedRoute = ({ children, allowedRoles }) => {
  const token = localStorage.getItem("token");
  const role = localStorage.getItem("role"); // "admin" or "staff"

  if (!token) {
    // Not logged in, redirect to login
    return <Navigate to="/" replace />;
  }

  if (allowedRoles && !allowedRoles.includes(role)) {
    // Logged in, but role not allowed
    // Example: staff trying to access admin panel
    return <Navigate to="/transcript" replace />;
  }

  return children;
};

export default ProtectedRoute;
