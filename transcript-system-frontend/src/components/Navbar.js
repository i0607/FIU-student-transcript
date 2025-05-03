import { useState, useEffect, useRef } from "react";
import { Link, useLocation } from "react-router-dom";
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import IconButton from '@mui/material/IconButton';
import Avatar from '@mui/material/Avatar';
import Menu from '@mui/material/Menu';
import MenuItem from '@mui/material/MenuItem';
import ListItemIcon from '@mui/material/ListItemIcon';
import Divider from '@mui/material/Divider';
import Settings from '@mui/icons-material/Settings';
import Logout from '@mui/icons-material/Logout';
import Person from '@mui/icons-material/Person';
import MenuIcon from '@mui/icons-material/Menu';
import ChevronLeftIcon from '@mui/icons-material/ChevronLeft';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemText from '@mui/material/ListItemText';
import Drawer from '@mui/material/Drawer';
import CssBaseline from '@mui/material/CssBaseline';
import { styled } from '@mui/material/styles';
import { useNavigate } from "react-router-dom";

// Styled components for sidebar
const drawerWidth = 240;

const Main = styled('main', { shouldForwardProp: (prop) => prop !== 'open' })(
  ({ theme, open }) => ({
    flexGrow: 1,
    padding: theme.spacing(3),
    marginLeft: `-${drawerWidth}px`,
    transition: theme.transitions.create('margin', {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.leavingScreen,
    }),
    ...(open && {
      marginLeft: 0,
      transition: theme.transitions.create('margin', {
        easing: theme.transitions.easing.easeOut,
        duration: theme.transitions.duration.enteringScreen,
      }),
    }),
  }),
);

const DrawerHeader = styled('div')(({ theme }) => ({
  display: 'flex',
  alignItems: 'center',
  padding: theme.spacing(0, 1),
  // necessary for content to be below app bar
  ...theme.mixins.toolbar,
  justifyContent: 'flex-end',
}));



function Navbar() {
  const role = localStorage.getItem('userRole'); // Get role from localStorage
  const [userName, setUserName] = useState(localStorage.getItem('name') || 'User');
  const location = useLocation();
  const sidebarRef = useRef(null);
  const navigate = useNavigate();

const handleLogout = () => {
  localStorage.removeItem("token");
  navigate("/login"); // Redirect to login page
};
  // State for user menu
  const [anchorEl, setAnchorEl] = useState(null);
  const open = Boolean(anchorEl);
  
  // State for sidebar
  const [sidebarOpen, setSidebarOpen] = useState(true);
  
  // Handle user menu
  const handleUserMenuClick = (event) => {
    setAnchorEl(event.currentTarget);
  };
  
  const handleUserMenuClose = () => {
    setAnchorEl(null);
  };

  // Toggle sidebar
  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
  };

  // Effect to update userName if it changes in localStorage
  useEffect(() => {
    const handleStorageChange = () => {
      const storedName = localStorage.getItem('userName');
      if (storedName) {
        setUserName(storedName);
      }
    };
    
    window.addEventListener('storage', handleStorageChange);
    return () => window.removeEventListener('storage', handleStorageChange);
  }, []);

  // Effect to close sidebar when clicking outside
  useEffect(() => {
    function handleClickOutside(event) {
      if (sidebarRef.current && 
          !sidebarRef.current.contains(event.target) && 
          !event.target.closest('[aria-label="toggle sidebar"]') && 
          sidebarOpen) {
        setSidebarOpen(false);
      }
    }

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [sidebarOpen]);

  // Navigation links based on user role
  const navigationLinks = [
    { text: 'Transcript', path: '/transcript' },
    ...(role === 'admin' ? [
      { text: 'Dashboard', path: '/admin/dashboard' },
      { text: 'Admin Panel', path: '/admin' },
      { text: 'Manage Departments', path: '/admin/departments' }
    ] : [])
  ];

  return (
    <Box sx={{ display: 'flex' }}>
      <CssBaseline />
      
      {/* App Bar */}
      <AppBar 
        position="fixed" 
        sx={{ 
          bgcolor: '#000000',
          zIndex: (theme) => theme.zIndex.drawer + 1 
        }}
      >
        <Toolbar>
          {/* Menu toggle button */}
          <IconButton
            color="inherit"
            aria-label="toggle sidebar"
            onClick={toggleSidebar}
            edge="start"
            sx={{ mr: 2 }}
          >
            <MenuIcon />
          </IconButton>

          {/* Logo and Title */}
          <Box sx={{ display: 'flex', alignItems: 'center', flexGrow: 1 }}>
            <img 
              src="/logo195.png" 
              alt="FIU Logo" 
              style={{ height: 40, marginRight: 12 }}
            />
            <Typography variant="h6" component="div" noWrap>
              Transcript System
            </Typography>
          </Box>

          {/* User Profile */}
          <Box sx={{ display: 'flex', alignItems: 'center' }}>
            <IconButton
              onClick={handleUserMenuClick}
              size="small"
              aria-controls={open ? 'account-menu' : undefined}
              aria-haspopup="true"
              aria-expanded={open ? 'true' : undefined}
              color="inherit"
              sx={{ display: 'flex', alignItems: 'center' }}
            >
              <Avatar sx={{ width: 32, height: 32, bgcolor: '#f5f5f5', color: '#CC0000' }}>
                {userName.charAt(0)}
              </Avatar>
              <Typography variant="body2" sx={{ ml: 1 }}>
                {userName}
              </Typography>
            </IconButton>
            
            {/* User Dropdown Menu */}
            <Menu
              anchorEl={anchorEl}
              id="account-menu"
              open={open}
              onClose={handleUserMenuClose}
              onClick={handleUserMenuClose}
              transformOrigin={{ horizontal: 'right', vertical: 'top' }}
              anchorOrigin={{ horizontal: 'right', vertical: 'bottom' }}
              PaperProps={{
                sx: {
                  width: 200,
                  mt: 1
                }
              }}
            >
              <MenuItem component={Link} to="/profile">
                <ListItemIcon>
                  <Person fontSize="small" />
                </ListItemIcon>
                My Profile
              </MenuItem>
              <MenuItem component={Link} to="/profile/settings">
                <ListItemIcon>
                  <Settings fontSize="small" />
                </ListItemIcon>
                Settings
              </MenuItem>
              <Divider />
              <MenuItem >
                <ListItemIcon>
                  <Logout fontSize="small" onClick={handleLogout}/>
                </ListItemIcon>
                Logout
              </MenuItem>
            </Menu>
          </Box>
        </Toolbar>
      </AppBar>

      {/* Sidebar */}
      <Drawer
        sx={{
          width: drawerWidth,
          flexShrink: 0,
          '& .MuiDrawer-paper': {
            width: drawerWidth,
            boxSizing: 'border-box',
          },
        }}
        variant="persistent"
        anchor="left"
        open={sidebarOpen}
      >
        <DrawerHeader>
          <Box sx={{ p: 2, display: 'flex', alignItems: 'center', width: '100%' }}>
            <Avatar sx={{ width: 40, height: 40, bgcolor: '#CC0000', color: '#fff', mr: 2 }}>
              {userName.charAt(0)}
            </Avatar>
            <Typography variant="subtitle1" noWrap sx={{ flexGrow: 1 }}>
              {userName}
            </Typography>
            <IconButton onClick={toggleSidebar}>
              <ChevronLeftIcon />
            </IconButton>
          </Box>
        </DrawerHeader>
        
        <Divider />
        
        <List>
          {navigationLinks.map((link) => (
            <ListItem key={link.text} disablePadding>
              <ListItemButton 
                component={Link} 
                to={link.path}
                selected={location.pathname === link.path}
                sx={{
                  '&.Mui-selected': {
                    backgroundColor: '#ffeeee',
                    '&:hover': {
                      backgroundColor: '#ffe0e0',
                    },
                  },
                }}
              >
                <ListItemText primary={link.text} />
              </ListItemButton>
            </ListItem>
          ))}
        </List>
        
        <Divider />
        
        <List>
          <ListItem disablePadding>
            <ListItemButton 
              component={Link} 
              to="/profile"
              selected={location.pathname === '/profile'}
              sx={{
                '&.Mui-selected': {
                  backgroundColor: '#ffeeee',
                  '&:hover': {
                    backgroundColor: '#ffe0e0',
                  },
                },
              }}
            >
              <ListItemIcon>
                <Person fontSize="small" />
              </ListItemIcon>
              <ListItemText primary="My Profile" />
            </ListItemButton>
          </ListItem>
          <ListItem disablePadding>
            <ListItemButton 
              component={Link} 
              to="/profile/settings"
              selected={location.pathname === '/profile/settings'}
              sx={{
                '&.Mui-selected': {
                  backgroundColor: '#ffeeee',
                  '&:hover': {
                    backgroundColor: '#ffe0e0',
                  },
                },
              }}
            >
              <ListItemIcon>
                <Settings fontSize="small" />
              </ListItemIcon>
              <ListItemText primary="Settings" />
            </ListItemButton>
          </ListItem>
          <ListItem disablePadding>
            <ListItemButton component={Link} to="/logout">
              <ListItemIcon>
                <Logout fontSize="small" />
              </ListItemIcon>
              <ListItemText primary="Logout" />
            </ListItemButton>
          </ListItem>
        </List>
      </Drawer>

      {/* Main content - This is where your page content will go */}
      <Main open={sidebarOpen}>
        <DrawerHeader />
        {/* Your page content will be rendered here */}
      </Main>
    </Box>
  );
}

export default Navbar;