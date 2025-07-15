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
import Badge from '@mui/material/Badge';
import Tooltip from '@mui/material/Tooltip';
import Button from '@mui/material/Button';
import Chip from '@mui/material/Chip';
import Collapse from '@mui/material/Collapse';
import Settings from '@mui/icons-material/Settings';
import Logout from '@mui/icons-material/Logout';
import Person from '@mui/icons-material/Person';
import MenuIcon from '@mui/icons-material/Menu';
import ChevronLeftIcon from '@mui/icons-material/ChevronLeft';
import ChevronRightIcon from '@mui/icons-material/ChevronRight';
import ExpandLess from '@mui/icons-material/ExpandLess';
import ExpandMore from '@mui/icons-material/ExpandMore';
import DashboardIcon from '@mui/icons-material/Dashboard';
import SchoolIcon from '@mui/icons-material/School';
import AdminPanelSettingsIcon from '@mui/icons-material/AdminPanelSettings';
import BusinessIcon from '@mui/icons-material/Business';
import DescriptionIcon from '@mui/icons-material/Description';
import NotificationsIcon from '@mui/icons-material/Notifications';
import SearchIcon from '@mui/icons-material/Search';
import HelpOutlineIcon from '@mui/icons-material/HelpOutline';
import BrightnessIcon from '@mui/icons-material/Brightness4';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemText from '@mui/material/ListItemText';
import Drawer from '@mui/material/Drawer';
import CssBaseline from '@mui/material/CssBaseline';
import { styled, useTheme } from '@mui/material/styles';
import { useNavigate } from "react-router-dom";

// Enhanced styled components
const drawerWidth = 280;
const miniDrawerWidth = 72;

const Main = styled('main', { shouldForwardProp: (prop) => prop !== 'open' && prop !== 'collapsed' })(
  ({ theme, open, collapsed }) => ({
    flexGrow: 1,
    padding: theme.spacing(3),
    paddingTop: theme.spacing(3), // Normal padding top
    marginTop: '64px', // Account for AppBar height
    transition: theme.transitions.create('margin', {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.leavingScreen,
    }),
    marginLeft: `-${drawerWidth}px`,
    ...(open && {
      transition: theme.transitions.create('margin', {
        easing: theme.transitions.easing.easeOut,
        duration: theme.transitions.duration.enteringScreen,
      }),
      marginLeft: collapsed ? `-${miniDrawerWidth}px` : 0,
    }),
  }),
);

const DrawerHeader = styled('div')(({ theme }) => ({
  display: 'flex',
  alignItems: 'center',
  padding: theme.spacing(0, 1),
  ...theme.mixins.toolbar,
  justifyContent: 'space-between',
  background: 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
  color: 'white',
}));

const StyledDrawer = styled(Drawer)(({ theme, collapsed }) => ({
  width: collapsed ? miniDrawerWidth : drawerWidth,
  flexShrink: 0,
  '& .MuiDrawer-paper': {
    width: collapsed ? miniDrawerWidth : drawerWidth,
    boxSizing: 'border-box',
    background: 'linear-gradient(180deg, #ffffff 0%, #f8fafc 100%)',
    borderRight: '1px solid #e2e8f0',
    transition: theme.transitions.create('width', {
      easing: theme.transitions.easing.sharp,
      duration: theme.transitions.duration.leavingScreen,
    }),
    overflowX: 'hidden',
  },
}));

const ProfileSection = styled(Box)(({ theme }) => ({
  padding: theme.spacing(2),
  background: 'linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%)',
  borderRadius: theme.spacing(1),
  margin: theme.spacing(1),
  textAlign: 'center',
}));

function EnhancedNavbar() {
  const role = localStorage.getItem('userRole');
  const [userName, setUserName] = useState(localStorage.getItem('name') || 'User');
  const [userEmail, setUserEmail] = useState(localStorage.getItem('email') || 'user@example.com');
  const location = useLocation();
  const sidebarRef = useRef(null);
  const navigate = useNavigate();
  const theme = useTheme();

  // Enhanced state management
  const [anchorEl, setAnchorEl] = useState(null);
  const [sidebarOpen, setSidebarOpen] = useState(true);
  const [sidebarCollapsed, setSidebarCollapsed] = useState(false);
  const [adminExpanded, setAdminExpanded] = useState(false);

  const userMenuOpen = Boolean(anchorEl);

  const handleLogout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("userRole");
    localStorage.removeItem("name");
    localStorage.removeItem("email");
    navigate("/");
  };

  const handleUserMenuClick = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleUserMenuClose = () => {
    setAnchorEl(null);
  };

  const toggleSidebar = () => {
    setSidebarOpen(!sidebarOpen);
    if (!sidebarOpen) {
      setSidebarCollapsed(false);
    }
  };

  const toggleSidebarCollapse = () => {
    setSidebarCollapsed(!sidebarCollapsed);
  };

  const handleSidebarNavigation = (path) => {
    navigate(path);
    if (window.innerWidth < 768) {
      setSidebarOpen(false);
    }
  };

  const handleAdminToggle = () => {
    setAdminExpanded(!adminExpanded);
  };

  // Enhanced navigation structure
  const navigationLinks = [
    { 
      text: 'Transcript', 
      path: '/transcript', 
      icon: <DescriptionIcon />,
      description: 'View and manage transcripts'
    },
    { 
      text: 'Curriculum', 
      path: '/curriculum', 
      icon: <SchoolIcon />,
      description: 'Browse curriculum information'
    },
  ];

  const adminLinks = [
    { 
      text: 'Dashboard', 
      path: '/admin/dashboard', 
      icon: <DashboardIcon />,
      description: 'Admin overview and analytics'
    },
    { 
      text: 'Admin Panel', 
      path: '/admin', 
      icon: <AdminPanelSettingsIcon />,
      description: 'System administration'
    },
    { 
      text: 'Manage Departments', 
      path: '/admin/departments', 
      icon: <BusinessIcon />,
      description: 'Department management'
    }
  ];

  // Effects
  useEffect(() => {
    const handleStorageChange = () => {
      const storedName = localStorage.getItem('name') || localStorage.getItem('userName');
      const storedEmail = localStorage.getItem('email');
      if (storedName) setUserName(storedName);
      if (storedEmail) setUserEmail(storedEmail);
    };
    
    window.addEventListener('storage', handleStorageChange);
    return () => window.removeEventListener('storage', handleStorageChange);
  }, []);

  useEffect(() => {
    const handleClickOutside = (event) => {
      const sidebar = sidebarRef.current;
      const isClickInsideSidebar = sidebar && sidebar.contains(event.target);
      const isToggleButton = event.target.closest('[aria-label="toggle sidebar"]');
      const isUserMenu = event.target.closest('#account-menu');
      const isUserButton = event.target.closest('button') && event.target.closest('button').getAttribute('aria-controls') === 'account-menu';
  
      // Close sidebar if clicking outside, but not on toggle button, user menu, or user button
      if (!isClickInsideSidebar && !isToggleButton && !isUserMenu && !isUserButton && sidebarOpen) {
        setSidebarOpen(false);
      }
    };
  
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, [sidebarOpen]);

  const renderNavigationItem = (link, isAdmin = false) => (
    <Tooltip 
      key={link.text} 
      title={sidebarCollapsed ? link.description : ''} 
      placement="right"
      arrow
    >
      <ListItem disablePadding sx={{ display: 'block' }}>
        <ListItemButton
          onClick={() => handleSidebarNavigation(link.path)}
          selected={location.pathname === link.path}
          sx={{
            minHeight: 48,
            justifyContent: sidebarCollapsed ? 'center' : 'initial',
            px: 2.5,
            borderRadius: 1,
            mx: 1,
            mb: 0.5,
            '&.Mui-selected': {
              backgroundColor: '#1e293b',
              color: 'white',
              '&:hover': {
                backgroundColor: '#334155',
              },
              '& .MuiListItemIcon-root': {
                color: 'white',
              },
            },
            '&:hover': {
              backgroundColor: '#f1f5f9',
              borderRadius: 1,
            },
          }}
        >
          <ListItemIcon
            sx={{
              minWidth: 0,
              mr: sidebarCollapsed ? 0 : 3,
              justifyContent: 'center',
              color: location.pathname === link.path ? 'white' : '#64748b',
            }}
          >
            {link.icon}
          </ListItemIcon>
          {!sidebarCollapsed && (
            <ListItemText 
              primary={link.text}
              secondary={!isAdmin ? link.description : undefined}
              primaryTypographyProps={{
                fontSize: '0.875rem',
                fontWeight: location.pathname === link.path ? 600 : 400,
              }}
              secondaryTypographyProps={{
                fontSize: '0.75rem',
                color: '#64748b',
              }}
            />
          )}
        </ListItemButton>
      </ListItem>
    </Tooltip>
  );

  return (
    <Box sx={{ display: 'flex' }}>
      <CssBaseline />
      
      {/* Enhanced App Bar */}
      <AppBar 
        position="fixed" 
        sx={{ 
          background: 'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)',
          zIndex: (theme) => theme.zIndex.drawer + 1,
          boxShadow: '0 4px 20px rgba(0,0,0,0.1)',
        }}
      >
        <Toolbar sx={{ justifyContent: 'space-between' }}>
          {/* Left Section */}
          <Box sx={{ display: 'flex', alignItems: 'center' }}>
            <Tooltip title="Toggle sidebar" arrow>
              <IconButton
                color="inherit"
                aria-label="toggle sidebar"
                onClick={toggleSidebar}
                edge="start"
                sx={{ mr: 2 }}
              >
                <MenuIcon />
              </IconButton>
            </Tooltip>

            <Box sx={{ display: 'flex', alignItems: 'center' }}>
              <img 
                src="/logo193.png" 
                alt="FIU Logo" 
                style={{ height: 40, marginRight: 12 }}
              />
              <Typography variant="h6" component="div" noWrap sx={{ fontWeight: 600 }}>
                Transcript System
              </Typography>
            </Box>
          </Box>

          {/* Right Section */}
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
            {/* Role Badge */}
            <Chip 
              label={role?.toUpperCase() || 'USER'} 
              size="small" 
              sx={{ 
                bgcolor: role === 'admin' ? '#dc2626' : '#059669',
                color: 'white',
                fontWeight: 600,
                display: { xs: 'none', sm: 'flex' }
              }} 
            />

            {/* User Profile */}
            <Button
              onClick={handleUserMenuClick}
              color="inherit"
              sx={{ 
                display: 'flex', 
                alignItems: 'center',
                textTransform: 'none',
                borderRadius: 2,
                px: 1.5,
                '&:hover': {
                  backgroundColor: 'rgba(255,255,255,0.1)',
                }
              }}
            >
              <Avatar sx={{ 
                width: 32, 
                height: 32, 
                bgcolor: '#dc2626', 
                mr: 1,
                fontSize: '0.875rem',
                fontWeight: 600
              }}>
                {userName.charAt(0).toUpperCase()}
              </Avatar>
              <Box sx={{ textAlign: 'left', display: { xs: 'none', sm: 'block' } }}>
                <Typography variant="body2" sx={{ lineHeight: 1.2 }}>
                  {userName}
                </Typography>
                <Typography variant="caption" sx={{ color: 'rgba(255,255,255,0.7)' }}>
                  {role || 'User'}
                </Typography>
              </Box>
              <ChevronRightIcon sx={{ ml: 0.5, fontSize: 16 }} />
            </Button>
          </Box>
        </Toolbar>
      </AppBar>

      {/* Enhanced Sidebar */}
      <StyledDrawer
        ref={sidebarRef}
        variant="persistent"
        anchor="left"
        open={sidebarOpen}
        collapsed={sidebarCollapsed}
      >
        <DrawerHeader>
          {!sidebarCollapsed && (
            <Box sx={{ display: 'flex', alignItems: 'center' }}>
              <Avatar sx={{ 
                width: 40, 
                height: 40, 
                bgcolor: '#dc2626', 
                mr: 2,
                fontWeight: 600
              }}>
                {userName.charAt(0).toUpperCase()}
              </Avatar>
              <Box>
                <Typography variant="subtitle1" noWrap sx={{ fontWeight: 600 }}>
                  {userName}
                </Typography>
                <Typography variant="caption" sx={{ color: 'rgba(255,255,255,0.8)' }}>
                  {userEmail}
                </Typography>
              </Box>
            </Box>
          )}
          <Box>
            <Tooltip title={sidebarCollapsed ? "Expand sidebar" : "Collapse sidebar"} arrow>
              <IconButton 
                onClick={toggleSidebarCollapse} 
                sx={{ color: 'white', mr: 1 }}
              >
                {sidebarCollapsed ? <ChevronRightIcon /> : <ChevronLeftIcon />}
              </IconButton>
            </Tooltip>
            {!sidebarCollapsed && (
              <Tooltip title="Close sidebar" arrow>
                <IconButton onClick={toggleSidebar} sx={{ color: 'white' }}>
                  <ChevronLeftIcon />
                </IconButton>
              </Tooltip>
            )}
          </Box>
        </DrawerHeader>
        
        <Divider />
        
        {/* Main Navigation */}
        <List sx={{ pt: 2 }}>
          {navigationLinks.map((link) => renderNavigationItem(link))}
        </List>

        {/* Admin Section */}
        {role === 'admin' && (
          <>
            <Divider sx={{ mx: 2, my: 1 }} />
            {!sidebarCollapsed && (
              <Typography 
                variant="overline" 
                sx={{ 
                  px: 3, 
                  py: 1, 
                  color: '#64748b', 
                  fontWeight: 600,
                  fontSize: '0.75rem'
                }}
              >
                Administration
              </Typography>
            )}
            
            {sidebarCollapsed ? (
              <List>
                {adminLinks.map((link) => renderNavigationItem(link, true))}
              </List>
            ) : (
              <List>
                <ListItem disablePadding>
                  <ListItemButton
                    onClick={handleAdminToggle}
                    sx={{
                      mx: 1,
                      borderRadius: 1,
                      '&:hover': {
                        backgroundColor: '#f1f5f9',
                      },
                    }}
                  >
                    <ListItemIcon sx={{ color: '#64748b' }}>
                      <AdminPanelSettingsIcon />
                    </ListItemIcon>
                    <ListItemText 
                      primary="Admin Tools"
                      primaryTypographyProps={{
                        fontSize: '0.875rem',
                        fontWeight: 500,
                      }}
                    />
                    {adminExpanded ? <ExpandLess /> : <ExpandMore />}
                  </ListItemButton>
                </ListItem>
                <Collapse in={adminExpanded} timeout="auto" unmountOnExit>
                  <List component="div" disablePadding>
                    {adminLinks.map((link) => renderNavigationItem(link, true))}
                  </List>
                </Collapse>
              </List>
            )}
          </>
        )}

        {/* Bottom Section */}
        <Box sx={{ flexGrow: 1 }} />
        {!sidebarCollapsed && (
          <ProfileSection>
            <Typography variant="caption" color="textSecondary">
              Last login: {new Date().toLocaleDateString()}
            </Typography>
          </ProfileSection>
        )}
        
        <Divider />
        <List>
          {renderNavigationItem({ 
            text: 'Settings', 
            path: '/settings', 
            icon: <Settings />, 
            description: 'System preferences' 
          })}
          <ListItem disablePadding>
            <ListItemButton 
              onClick={handleLogout}
              sx={{
                minHeight: 48,
                justifyContent: sidebarCollapsed ? 'center' : 'initial',
                px: 2.5,
                borderRadius: 1,
                mx: 1,
                mb: 1,
                '&:hover': {
                  backgroundColor: '#fef2f2',
                  color: '#dc2626',
                  '& .MuiListItemIcon-root': {
                    color: '#dc2626',
                  },
                },
              }}
            >
              <ListItemIcon
                sx={{
                  minWidth: 0,
                  mr: sidebarCollapsed ? 0 : 3,
                  justifyContent: 'center',
                  color: '#64748b',
                }}
              >
                <Logout />
              </ListItemIcon>
              {!sidebarCollapsed && (
                <ListItemText 
                  primary="Logout"
                  primaryTypographyProps={{
                    fontSize: '0.875rem',
                    fontWeight: 500,
                  }}
                />
              )}
            </ListItemButton>
          </ListItem>
        </List>
      </StyledDrawer>

      {/* User Menu */}
      <Menu
        anchorEl={anchorEl}
        id="account-menu"
        open={userMenuOpen}
        onClose={handleUserMenuClose}
        onClick={handleUserMenuClose}
        transformOrigin={{ horizontal: 'right', vertical: 'top' }}
        anchorOrigin={{ horizontal: 'right', vertical: 'bottom' }}
        PaperProps={{
          sx: {
            width: 280,
            mt: 1,
            borderRadius: 2,
            boxShadow: '0 10px 40px rgba(0,0,0,0.1)',
          }
        }}
      >
        <Box sx={{ p: 2, bgcolor: '#f8fafc' }}>
          <Box sx={{ display: 'flex', alignItems: 'center', mb: 1 }}>
            <Avatar sx={{ bgcolor: '#dc2626', mr: 2 }}>
              {userName.charAt(0).toUpperCase()}
            </Avatar>
            <Box>
              <Typography variant="subtitle1" sx={{ fontWeight: 600 }}>
                {userName}
              </Typography>
              <Typography variant="body2" color="textSecondary">
                {userEmail}
              </Typography>
            </Box>
          </Box>
          <Chip 
            label={role?.toUpperCase() || 'USER'} 
            size="small" 
            sx={{ 
              bgcolor: role === 'admin' ? '#dc2626' : '#059669',
              color: 'white',
              fontWeight: 600
            }} 
          />
        </Box>
        <Divider />
        <MenuItem component={Link} to="/profile">
          <ListItemIcon>
            <Person fontSize="small" />
          </ListItemIcon>
          My Profile
        </MenuItem>
        
        <MenuItem onClick={() => {}}>
          <ListItemIcon>
            <BrightnessIcon fontSize="small" />
          </ListItemIcon>
          Dark Mode
        </MenuItem>
        <Divider />
        <MenuItem onClick={handleLogout} sx={{ color: '#dc2626' }}>
          <ListItemIcon>
            <Logout fontSize="small" sx={{ color: '#dc2626' }} />
          </ListItemIcon>
          Logout
        </MenuItem>
      </Menu>

      <Main open={sidebarOpen} collapsed={sidebarCollapsed}>
        {/* Your page content will be rendered here */}
      </Main>
    </Box>
  );
}

export default EnhancedNavbar;