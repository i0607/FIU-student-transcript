import React, { useEffect, useState } from 'react';
import axios from 'axios';
import {
  Paper,
  Typography,
  CircularProgress,
  Box,
  Stack
} from '@mui/material';
const ProfilePage = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    const token = localStorage.getItem("token");
  
    if (!token) return; // optionally handle missing token
  
    axios.get('http://127.0.0.1:8000/api/user/profile', {
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json'
      }
    })
    .then(res => setUser(res.data))
    .catch(err => console.error('Profile fetch failed:', err));
  }, []);
  

  return user ?(
    <Paper   elevation={3}
    sx={{
      p: 4,
      maxWidth: 500,
      margin: "2rem auto",
      boxShadow: "0 4px 20px rgba(255, 0, 0, 0.4)" // red shadow
    }}>
      <Typography variant="h5" gutterBottom>
        Profile
      </Typography>
      <Stack spacing={2}>
        <Typography><strong>Name:</strong> {user.name}</Typography>
        <Typography><strong>Email:</strong> {user.email}</Typography>
        <Typography><strong>Surname:</strong> {user.surname}</Typography>
        <Typography><strong>Department:</strong> {user.department}</Typography>
        <Typography><strong>Staff Number:</strong> {user.staffNumber}</Typography>
      </Stack>
    </Paper>):(<p>Loading...</p>
  );
};

export default ProfilePage;
