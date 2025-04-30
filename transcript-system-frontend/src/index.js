// src/index.js
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';

// Import MUI ThemeProvider and createTheme
import { ThemeProvider, createTheme } from '@mui/material/styles';

// (Optional) Import CSS if you still need it for some basic styles
import './index.css';

// Create a basic MUI theme (you can customize colors, fonts later)
const theme = createTheme({
  palette: {
    primary: {
      main: '#1976d2', // MUI blue
    },
    secondary: {
      main: '#dc004e', // MUI pink/red
    },
  },
});

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <ThemeProvider theme={theme}>
      <App />
    </ThemeProvider>
  </React.StrictMode>
);
