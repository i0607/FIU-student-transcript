import React, { useState } from "react";
import {
  Container,
  Box,
  TextField,
  Button,
  Typography,
  Paper,
  Divider,
} from "@mui/material";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import logo from "../logo195.png"; // Ensure this path is correct

function LoginPage() {
  const navigate = useNavigate();
  const [form, setForm] = useState({ email: "", password: "" });
  const [error, setError] = useState("");

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleLogin = async (e) => {
    e.preventDefault();
    setError("");

    try {
      const res = await axios.post("http://127.0.0.1:8000/api/login", form, {
        headers: { Accept: "application/json" },
      });

           // Store token and user role in localStorage
           localStorage.setItem("token", res.data.token);
           localStorage.setItem("userRole", res.data.user.role);
           if (res.data.user.role === "admin") {
            navigate("/admin/dashboard");
          } else if (res.data.user.role === "staff") {
            navigate("/transcript");
          } else {
            // For any other role, or as a fallback
            navigate("/transcript");
          }
    } catch (err) {
      setError("Login failed: Invalid credentials");
    }
  };

  return (
    <Box
      sx={{
        minHeight: "100vh",

        backgroundSize: "cover",
        backgroundPosition: "center",
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        alignItems: "center",
        px: 2,
      }}
    >
      <Paper
        elevation={8}
        sx={{
          padding: 5,
          maxWidth: 440,
          width: "100%",
          borderRadius: 4,
          backgroundColor: "rgba(255,255,255,0.95)",
        }}
      >
        <Box sx={{ textAlign: "center", mb: 3 }}>
          <img src={logo} alt="FIU Logo" style={{ width: 120, marginBottom: 10 }} />
          <Typography variant="h5" fontWeight="bold">
            FIU Transcript System
          </Typography>
          <Divider sx={{ my: 2 }} />
        </Box>

        {error && (
          <Typography color="error" textAlign="center" mb={2}>
            {error}
          </Typography>
        )}

        <form onSubmit={handleLogin}>
          <TextField
            label="Email"
            name="email"
            fullWidth
            margin="normal"
            variant="outlined"
            value={form.email}
            onChange={handleChange}
            required
          />
          <TextField
            label="Password"
            name="password"
            type="password"
            fullWidth
            margin="normal"
            variant="outlined"
            value={form.password}
            onChange={handleChange}
            required
          />
          <Button
            type="submit"
            fullWidth
            color="error"
            variant="contained"
            size="large"
            sx={{ mt: 3, py: 1.5, fontWeight: 'bold' }}
          >
            Login
          </Button>
        </form>
      </Paper>

      <Typography
        variant="body2"
        color="black"
        sx={{ mt: 4, textAlign: "center" }}
      >
        © Copyright_FIU
      </Typography>
    </Box>
  );
}

export default LoginPage;
