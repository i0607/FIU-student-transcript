import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { Box, TextField, Button, Typography, Alert } from '@mui/material';

function LoginPage() {
  const navigate = useNavigate();
  const [form, setForm] = useState({ email: "", password: "" });
  const [error, setError] = useState("");

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleLogin = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.post("http://127.0.0.1:8000/api/login", {
        email: form.email,
        password: form.password,
      }, {
        headers: {
          Accept: "application/json",
        },
      });
      console.log("✅ Login success:", res.data);
      localStorage.setItem("token", res.data.token);
      localStorage.setItem("role", res.data.user.role);

      navigate("/transcript");
    } catch (err) {
      setError("Login failed: Invalid credentials");
    }
  };

  return (
    <Box 
      maxWidth={400} 
      mx="auto" 
      mt={10} 
      p={4} 
      boxShadow={3} 
      borderRadius={2} 
      bgcolor="background.paper"
    >
      <Typography variant="h5" fontWeight="bold" mb={3} align="center">
        FIU Transcript Login
      </Typography>

      {error && (
        <Alert severity="error" sx={{ mb: 2 }}>
          {error}
        </Alert>
      )}

      <form onSubmit={handleLogin}>
        <TextField
          fullWidth
          label="Email"
          name="email"
          value={form.email}
          onChange={handleChange}
          margin="normal"
        />
        <TextField
          fullWidth
          label="Password"
          type="password"
          name="password"
          value={form.password}
          onChange={handleChange}
          margin="normal"
        />
        <Button 
          type="submit" 
          fullWidth 
          variant="contained" 
          color="primary" 
          sx={{ mt: 2 }}
        >
          Login
        </Button>
      </form>
    </Box>
  );
}

export default LoginPage;
