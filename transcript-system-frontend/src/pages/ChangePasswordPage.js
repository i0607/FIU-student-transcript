import React, { useState } from 'react';
import axios from 'axios';
import { TextField, Button, Typography, Stack, Paper, Alert } from "@mui/material";

const ChangePasswordPage = () => {
  const [form, setForm] = useState({
    current_password: '',
    new_password: '',
    new_password_confirmation: ''
  });
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    setForm({...form, [e.target.name]: e.target.value});
  };
  const token = localStorage.getItem("token");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
        await axios.put(
            'http://127.0.0.1:8000/api/me/password',
            {
              current_password: form.current_password,
              new_password: form.new_password,
              new_password_confirmation: form.new_password_confirmation
            },
            {
              headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
              }
            }
          );
          
      setMessage('Password updated successfully');
    } catch (err) {
      setMessage(err.response?.data?.message || 'Error updating password');
    }
  };

  return (
<Paper elevation={3} sx={{ p: 4, maxWidth: 400, margin: "0 auto" }}>
      <Typography variant="h5" gutterBottom>
        Change Password
      </Typography>

      {message && (
        <Alert severity="info" sx={{ mb: 2 }}>
          {message}
        </Alert>
      )}

      <form onSubmit={handleSubmit}>
        <Stack spacing={2}>
          <TextField
            label="Current Password"
            name="current_password"
            type="password"
            onChange={handleChange}
            required
            fullWidth
          />
          <TextField
            label="New Password"
            name="new_password"
            type="password"
            onChange={handleChange}
            required
            fullWidth
          />
          <TextField
            label="Confirm New Password"
            name="new_password_confirmation"
            type="password"
            onChange={handleChange}
            required
            fullWidth
          />
          <Button variant="contained" color="primary" type="submit">
            Change Password
          </Button>
        </Stack>
      </form>
    </Paper>
  
  );
};

export default ChangePasswordPage;
