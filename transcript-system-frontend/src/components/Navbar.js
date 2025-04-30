import { Link } from "react-router-dom";
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Stack from '@mui/material/Stack';

function Navbar() {
  const role = localStorage.getItem('role'); // 🔥 Get role from localStorage

  return (
    <AppBar position="static" color="primary">
      <Toolbar sx={{ display: "flex", justifyContent: "space-between" }}>
        {/* Left Side: Title */}
        <Typography variant="h6" component="div">
          FIU Transcript System
        </Typography>

        {/* Right Side: Navigation Links */}
        <Box>
          <Button color="inherit" component={Link} to="/transcript">
            Transcript
          </Button>

          {/* Show Admin links only if role === 'admin' */}
          {role === 'admin' && (
            <>
              <Button color="inherit" component={Link} to="/admin">
                Admin Panel
              </Button>
              <Button color="inherit" component={Link} to="/admin/departments">
                Manage Departments
              </Button>
            </>
          )}
        </Box>
      </Toolbar>
    </AppBar>
  );
}

export default Navbar;
