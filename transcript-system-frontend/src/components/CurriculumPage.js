// src/components/CurriculumPage.js
import React, { useState, useEffect, useMemo, useCallback } from 'react';
import {
  Box,
  Card,
  CardContent,
  Typography,
  Grid,
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  Chip,
  Accordion,
  AccordionSummary,
  AccordionDetails,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Alert,
  CircularProgress,
  Tabs,
  Tab,
  Stack,
  Divider,
  Badge,
  TextField,
  InputAdornment,
  Button,
  IconButton,
  Skeleton
} from '@mui/material';
import {
  ExpandMore,
  School,
  MenuBook,
  Assessment,
  Timeline,
  Category,
  Search,
  Clear,
  BarChart,
  PieChart,
  FilterList,
  Refresh
} from '@mui/icons-material';
import {
  PieChart as RechartsPieChart,
  Cell,
  Pie,
  BarChart as RechartsBarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
  Area,
  AreaChart
} from 'recharts';
import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';

// Constants for better maintainability
const CATEGORY_COLORS = {
  'AC': '#1976d2', // Area Core - Blue
  'AE': '#388e3c', // Area Elective - Green
  'UC': '#f57c00', // University Core - Orange
  'FC': '#7b1fa2', // Faculty Core - Purple
  'FE': '#c2185b', // Faculty Elective - Pink
  'UE': '#5d4037', // University Elective - Brown
  'Others': '#616161' // Others - Grey
};

const CATEGORY_NAMES = {
  'AC': 'Area Core',
  'AE': 'Area Elective',
  'UC': 'University Core',
  'FC': 'Faculty Core',
  'FE': 'Faculty Elective',
  'UE': 'University Elective'
};

const CATEGORY_PRIORITY = {
  'AC': 1, 'FC': 2, 'UC': 3, 'AE': 4, 'FE': 5, 'UE': 6
};

function TabPanel({ children, value, index, ...other }) {
  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`curriculum-tabpanel-${index}`}
      aria-labelledby={`curriculum-tab-${index}`}
      {...other}
    >
      {value === index && <Box sx={{ p: 3 }}>{children}</Box>}
    </div>
  );
}

function CurriculumPage() {
  // State management
  const [departments, setDepartments] = useState([]);
  const [selectedDepartment, setSelectedDepartment] = useState('');
  const [selectedVersion, setSelectedVersion] = useState('');
  const [curriculumData, setCurriculumData] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [tabValue, setTabValue] = useState(0);
  const [searchTerm, setSearchTerm] = useState('');
  const [searchFilters, setSearchFilters] = useState({
    category: '',
    semester: '',
    credits: ''
  });

  // Utility functions
  const getCategoryColor = useCallback((category) => {
    return CATEGORY_COLORS[category] || CATEGORY_COLORS['Others'];
  }, []);

  const getCategoryName = useCallback((category) => {
    const categoryUpper = (category || '').toUpperCase();
    return CATEGORY_NAMES[categoryUpper] || 'Others';
  }, []);

  // Improved semester comparison function
  const compareSemesters = useCallback((a, b) => {
    const isElectiveA = !a || a === '' || a === 'Elective' || a.toString().toLowerCase() === 'elective';
    const isElectiveB = !b || b === '' || b === 'Elective' || b.toString().toLowerCase() === 'elective';
    
    if (isElectiveA && isElectiveB) return 0;
    if (isElectiveA) return 1;
    if (isElectiveB) return -1;
    
    const getNumericValue = (semester) => {
      if (typeof semester === 'number') return semester;
      if (typeof semester === 'string') {
        const match = semester.match(/(\d+)/);
        return match ? parseInt(match[1], 10) : 999;
      }
      return 999;
    };
    
    return getNumericValue(a) - getNumericValue(b);
  }, []);

  const getSemesterDisplayName = useCallback((semester) => {
    if (!semester || semester === 'Elective' || semester.toString().toLowerCase() === 'elective') {
      return 'Elective Courses';
    }
    if (typeof semester === 'number') {
      return `Semester ${semester}`;
    }
    if (typeof semester === 'string') {
      if (semester.toLowerCase().includes('semester')) {
        return semester;
      }
      if (/^\d+$/.test(semester.trim())) {
        return `Semester ${semester}`;
      }
      return semester;
    }
    return `Semester ${semester}`;
  }, []);

  // Sorting functions
  const getSortedSemesters = useCallback((semesters) => {
    return [...semesters].sort((a, b) => compareSemesters(a.semester, b.semester));
  }, [compareSemesters]);

  const getSortedCourses = useCallback((courses) => {
    return [...courses].sort((a, b) => {
      const priorityA = CATEGORY_PRIORITY[a.category] || 7;
      const priorityB = CATEGORY_PRIORITY[b.category] || 7;
      
      if (priorityA !== priorityB) {
        return priorityA - priorityB;
      }
      
      return a.code.localeCompare(b.code);
    });
  }, []);

  const getSortedAllCourses = useCallback((courses) => {
    return [...courses].sort((a, b) => {
      const semesterDiff = compareSemesters(a.semester, b.semester);
      if (semesterDiff !== 0) return semesterDiff;
      
      const priorityA = CATEGORY_PRIORITY[a.category] || 7;
      const priorityB = CATEGORY_PRIORITY[b.category] || 7;
      
      if (priorityA !== priorityB) {
        return priorityA - priorityB;
      }
      
      return a.code.localeCompare(b.code);
    });
  }, [compareSemesters]);

  // Filtering functions
  const getNonElectiveCourses = useCallback((courses) => {
    return courses.filter(course => 
      course.semester && 
      course.semester !== 'Elective' && 
      course.semester.toString().toLowerCase() !== 'elective'
    );
  }, []);

  const filterCourses = useCallback((courses) => {
    if (!searchTerm && !searchFilters.category && !searchFilters.semester && !searchFilters.credits) {
      return courses;
    }

    return courses.filter(course => {
      const matchesSearch = !searchTerm || 
        course.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
        course.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        course.category_name.toLowerCase().includes(searchTerm.toLowerCase());

      const matchesCategory = !searchFilters.category || 
        course.category === searchFilters.category;

      const matchesSemester = !searchFilters.semester || 
        course.semester === searchFilters.semester;

      const matchesCredits = !searchFilters.credits || 
        course.credits.toString() === searchFilters.credits;

      return matchesSearch && matchesCategory && matchesSemester && matchesCredits;
    });
  }, [searchTerm, searchFilters]);

  // Memoized computed values
  const getNonElectiveStats = useMemo(() => {
    if (!curriculumData?.all_courses) return { totalCourses: 0, totalCredits: 0, totalEcts: 0 };
    
    const nonElectiveCourses = getNonElectiveCourses(curriculumData.all_courses);
    return {
      totalCourses: nonElectiveCourses.length,
      totalCredits: nonElectiveCourses.reduce((sum, course) => sum + course.credits, 0),
      totalEcts: nonElectiveCourses.reduce((sum, course) => sum + course.ects, 0)
    };
  }, [curriculumData?.all_courses, getNonElectiveCourses]);

  const filteredCourses = useMemo(() => {
    if (!curriculumData?.all_courses) return [];
    return filterCourses(curriculumData.all_courses);
  }, [curriculumData?.all_courses, filterCourses]);

  const getUniqueValues = useCallback((courses, field) => {
    const values = [...new Set(courses.map(course => course[field]))];
    if (field === 'semester') {
      return values.filter(value => value && value !== 'Elective').sort(compareSemesters);
    }
    return values.filter(value => value && value !== 'Elective').sort();
  }, [compareSemesters]);

  // Chart data preparation
  const prepareCategoryChartData = useMemo(() => {
    if (!curriculumData?.statistics?.category_breakdown) return [];
    
    return curriculumData.statistics.category_breakdown
      .map((cat) => {
        const categoryNonElectiveCourses = curriculumData.all_courses.filter(course => 
          course.category === cat.category && 
          course.semester && 
          course.semester !== 'Elective' && 
          course.semester.toString().toLowerCase() !== 'elective'
        );
        
        const count = categoryNonElectiveCourses.length;
        const credits = categoryNonElectiveCourses.reduce((sum, course) => sum + course.credits, 0);
        const ects = categoryNonElectiveCourses.reduce((sum, course) => sum + course.ects, 0);
        
        return {
          name: cat.category_name,
          value: count,
          credits: credits,
          ects: ects,
          percentage: getNonElectiveStats.totalCourses > 0 ? ((count / getNonElectiveStats.totalCourses) * 100).toFixed(1) : '0',
          color: getCategoryColor(cat.category)
        };
      })
      .filter(cat => cat.value > 0);
  }, [curriculumData?.statistics?.category_breakdown, curriculumData?.all_courses, getNonElectiveStats, getCategoryColor]);

  const prepareSemesterChartData = useMemo(() => {
    if (!curriculumData?.statistics?.semester_breakdown) return [];
    
    return curriculumData.statistics.semester_breakdown
      .filter(sem => sem.semester !== 'Elective')
      .sort((a, b) => compareSemesters(a.semester, b.semester))
      .map(sem => ({
        semester: getSemesterDisplayName(sem.semester),
        courses: sem.count,
        credits: sem.credits,
        ects: sem.ects
      }));
  }, [curriculumData?.statistics?.semester_breakdown, compareSemesters, getSemesterDisplayName]);

  const prepareCumulativeData = useMemo(() => {
    if (!curriculumData?.statistics?.semester_breakdown) return [];
    
    const semesterData = curriculumData.statistics.semester_breakdown
      .filter(sem => sem.semester !== 'Elective')
      .sort((a, b) => compareSemesters(a.semester, b.semester));

    let cumulativeCourses = 0;
    let cumulativeCredits = 0;
    let cumulativeEcts = 0;

    return semesterData.map(sem => {
      cumulativeCourses += sem.count;
      cumulativeCredits += sem.credits;
      cumulativeEcts += sem.ects;
      
      return {
        semester: getSemesterDisplayName(sem.semester),
        cumulativeCourses,
        cumulativeCredits,
        cumulativeEcts,
        semesterCourses: sem.count,
        semesterCredits: sem.credits
      };
    });
  }, [curriculumData?.statistics?.semester_breakdown, compareSemesters, getSemesterDisplayName]);

  // Event handlers
  const handleSearchChange = useCallback((event) => {
    setSearchTerm(event.target.value);
  }, []);

  const handleFilterChange = useCallback((filterType, value) => {
    setSearchFilters(prev => ({
      ...prev,
      [filterType]: value
    }));
  }, []);

  const clearAllFilters = useCallback(() => {
    setSearchTerm('');
    setSearchFilters({
      category: '',
      semester: '',
      credits: ''
    });
  }, []);

  const hasActiveFilters = useCallback(() => {
    return searchTerm || searchFilters.category || searchFilters.semester || searchFilters.credits;
  }, [searchTerm, searchFilters]);

  const getFilteredSemesters = useCallback((semesters) => {
    return semesters.map(semester => ({
      ...semester,
      courses: filterCourses(semester.courses)
    })).filter(semester => semester.courses.length > 0);
  }, [filterCourses]);

  const getFilteredCategories = useCallback((categories) => {
    return categories.map(category => ({
      ...category,
      courses: filterCourses(category.courses)
    })).filter(category => category.courses.length > 0);
  }, [filterCourses]);

  // API calls
  const fetchDepartments = useCallback(async () => {
    try {
      setLoading(true);
      setError(null);
      
      const response = await axios.get(`${API_BASE_URL}/curriculum/departments`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json'
        }
      });
      
      if (response.data.success) {
        setDepartments(response.data.data.departments);
      } else {
        throw new Error(response.data.message || 'Failed to fetch departments');
      }
    } catch (err) {
      const errorMessage = getErrorMessage(err);
      setError(errorMessage);
      console.error('Error fetching departments:', err);
    } finally {
      setLoading(false);
    }
  }, []);

  const fetchCurriculumData = useCallback(async (departmentId, version) => {
    try {
      setLoading(true);
      setError(null);
      
      const response = await axios.get(`${API_BASE_URL}/curriculum/search`, {
        params: { department_id: departmentId, version },
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('token')}`,
          'Content-Type': 'application/json'
        }
      });
      
      if (response.data.success) {
        setCurriculumData(response.data.data);
      } else {
        throw new Error(response.data.message || 'Failed to fetch curriculum data');
      }
    } catch (err) {
      const errorMessage = getErrorMessage(err);
      setError(errorMessage);
      setCurriculumData(null);
      console.error('Error fetching curriculum data:', err);
    } finally {
      setLoading(false);
    }
  }, []);

  const getErrorMessage = useCallback((err) => {
    if (err.response?.status === 401) {
      return 'Unauthorized access. Please login again.';
    } else if (err.response?.status === 403) {
      return 'Access denied. You don\'t have permission to view this data.';
    } else if (err.response?.status >= 500) {
      return 'Server error. Please try again later.';
    } else if (err.response?.data?.message) {
      return err.response.data.message;
    }
    return 'An unexpected error occurred. Please try again.';
  }, []);

  const handleDepartmentChange = useCallback((event) => {
    const departmentId = event.target.value;
    setSelectedDepartment(departmentId);
    setSelectedVersion('');
    setCurriculumData(null);
    setError(null);
  }, []);

  const handleVersionChange = useCallback((event) => {
    const version = event.target.value;
    setSelectedVersion(version);
    
    if (selectedDepartment && version) {
      fetchCurriculumData(selectedDepartment, version);
    }
  }, [selectedDepartment, fetchCurriculumData]);

  const handleTabChange = useCallback((event, newValue) => {
    setTabValue(newValue);
  }, []);

  // Effects
  useEffect(() => {
    fetchDepartments();
  }, [fetchDepartments]);

  // Custom chart components
  const CustomTooltip = ({ active, payload, label }) => {
    if (active && payload && payload.length) {
      return (
        <Paper sx={{ p: 2, border: '1px solid #ccc' }}>
          <Typography variant="body2" sx={{ fontWeight: 'bold' }}>
            {label}
          </Typography>
          {payload.map((entry, index) => (
            <Typography
              key={index}
              variant="body2"
              sx={{ color: entry.color }}
            >
              {`${entry.name}: ${entry.value}`}
              {entry.payload.percentage && ` (${entry.payload.percentage}%)`}
            </Typography>
          ))}
        </Paper>
      );
    }
    return null;
  };

  const renderCustomizedLabel = ({ cx, cy, midAngle, innerRadius, outerRadius, percent }) => {
    if (percent < 0.05) return null;
    
    const RADIAN = Math.PI / 180;
    const radius = innerRadius + (outerRadius - innerRadius) * 0.5;
    const x = cx + radius * Math.cos(-midAngle * RADIAN);
    const y = cy + radius * Math.sin(-midAngle * RADIAN);

    return (
      <text 
        x={x} 
        y={y} 
        fill="white" 
        textAnchor={x > cx ? 'start' : 'end'} 
        dominantBaseline="central"
        fontSize="12"
        fontWeight="bold"
      >
        {`${(percent * 100).toFixed(0)}%`}
      </text>
    );
  };

  // Component definitions
  const StatCard = ({ title, value, subtitle, icon: Icon, isLoading = false }) => (
    <Card sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
      <CardContent sx={{ flexGrow: 1 }}>
        <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
          <Icon sx={{ mr: 1, color: '#1976d2' }} />
          <Typography variant="h6" component="div" sx={{ fontWeight: 'bold' }}>
            {title}
          </Typography>
        </Box>
        {isLoading ? (
          <Skeleton variant="text" width="60%" height={40} />
        ) : (
          <Typography variant="h4" sx={{ fontWeight: 'bold', color: '#1976d2', mb: 1 }}>
            {value}
          </Typography>
        )}
        {subtitle && !isLoading && (
          <Typography variant="body2" color="text.secondary">
            {subtitle}
          </Typography>
        )}
      </CardContent>
    </Card>
  );

  const CourseTable = ({ courses, showSemester = false }) => (
    <TableContainer component={Paper} sx={{ mt: 2 }}>
      <Table>
        <TableHead>
          <TableRow sx={{ backgroundColor: '#f5f5f5' }}>
            <TableCell><strong>Course Code</strong></TableCell>
            <TableCell><strong>Course Title</strong></TableCell>
            <TableCell align="center"><strong>Credits</strong></TableCell>
            <TableCell align="center"><strong>ECTS</strong></TableCell>
            <TableCell><strong>Category</strong></TableCell>
            {showSemester && <TableCell align="center"><strong>Semester</strong></TableCell>}
            <TableCell><strong>Prerequisites</strong></TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {courses.map((course) => (
            <TableRow key={course.course_id} hover>
              <TableCell>
                <Typography variant="body2" sx={{ fontWeight: 'bold', color: '#1976d2' }}>
                  {course.code}
                </Typography>
              </TableCell>
              <TableCell>
                <Typography variant="body2">
                  {course.title}
                </Typography>
              </TableCell>
              <TableCell align="center">
                <Chip 
                  label={course.credits} 
                  size="small" 
                  sx={{ backgroundColor: '#e3f2fd', color: '#1976d2' }}
                />
              </TableCell>
              <TableCell align="center">
                <Chip 
                  label={course.ects} 
                  size="small" 
                  sx={{ backgroundColor: '#e8f5e8', color: '#2e7d32' }}
                />
              </TableCell>
              <TableCell>
                <Chip 
                  label={course.category_name} 
                  size="small" 
                  sx={{ 
                    backgroundColor: getCategoryColor(course.category) + '20',
                    color: getCategoryColor(course.category),
                    fontWeight: 'bold'
                  }}
                />
              </TableCell>
              {showSemester && (
                <TableCell align="center">
                  <Chip 
                    label={getSemesterDisplayName(course.semester)} 
                    size="small" 
                    variant="outlined"
                  />
                </TableCell>
              )}
              <TableCell>
                <Typography variant="body2" color="text.secondary">
                  {course.pre_requisite || 'None'}
                </Typography>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );

  return (
    <Box sx={{ p: 3, width: '100%', minHeight: '100vh' }}>
      {/* Header */}
      <Box sx={{ mb: 4 }}>
        <Typography variant="h4" component="h1" gutterBottom sx={{ fontWeight: 'bold' }}>
          Curriculum Management
        </Typography>
        <Typography variant="subtitle1" color="text.secondary">
          View and analyze curriculum structure by department and version
        </Typography>
        
        {/* Show current selection */}
        {curriculumData && (
          <Box sx={{ mt: 2, p: 2, backgroundColor: '#f5f5f5', borderRadius: 1 }}>
            <Typography variant="body1" sx={{ fontWeight: 'bold' }}>
              Currently Viewing: {curriculumData.department.name} - {curriculumData.version} Curriculum
            </Typography>
          </Box>
        )}
      </Box>

      {/* Department and Version Selection */}
      <Card sx={{ mb: 4 }}>
        <CardContent>
          <Grid container spacing={3}>
            <Grid item xs={12} md={6}>
              <FormControl fullWidth>
                <InputLabel>Select Department</InputLabel>
                <Select
                  value={selectedDepartment}
                  onChange={handleDepartmentChange}
                  label="Select Department"
                  disabled={loading}
                >
                  {departments.map((dept) => (
                    <MenuItem key={dept.id} value={dept.id}>
                      {dept.name}
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Grid>
            
            <Grid item xs={12} md={6}>
              <FormControl fullWidth disabled={!selectedDepartment || loading}>
                <InputLabel>Select Version</InputLabel>
                <Select
                  value={selectedVersion}
                  onChange={handleVersionChange}
                  label="Select Version"
                >
                  {selectedDepartment && 
                    departments
                      .find(dept => dept.id === selectedDepartment)
                      ?.available_versions.map((version) => (
                        <MenuItem key={version} value={version}>
                          {version} Curriculum
                        </MenuItem>
                      ))
                  }
                </Select>
              </FormControl>
            </Grid>
          </Grid>
          
          {/* Refresh button */}
          <Box sx={{ mt: 2, display: 'flex', justifyContent: 'flex-end' }}>
            <Button
              startIcon={<Refresh />}
              onClick={fetchDepartments}
              disabled={loading}
              variant="outlined"
              size="small"
            >
              Refresh Departments
            </Button>
          </Box>
        </CardContent>
      </Card>

      {/* Loading State */}
      {loading && (
        <Box sx={{ display: 'flex', justifyContent: 'center', my: 4 }}>
          <CircularProgress />
        </Box>
      )}

      {/* Error State */}
      {error && (
        <Alert 
          severity="error" 
          sx={{ mb: 4 }}
          action={
            <Button color="inherit" size="small" onClick={fetchDepartments}>
              Retry
            </Button>
          }
        >
          {error}
        </Alert>
      )}

      {/* Curriculum Data Display */}
      {curriculumData && (
        <Box>
          {/* Department Info */}
          <Card sx={{ mb: 4, background: 'linear-gradient(135deg, #1976d2 0%, #42a5f5 100%)', color: 'white' }}>
            <CardContent>
              <Grid container spacing={2} alignItems="center">
                <Grid item>
                  <School sx={{ fontSize: 50, color: 'white' }} />
                </Grid>
                <Grid item xs>
                  <Typography variant="h4" sx={{ fontWeight: 'bold', mb: 1 }}>
                    {curriculumData.department.name}
                  </Typography>
                  <Typography variant="h6" sx={{ opacity: 0.9, mb: 1 }}>
                    {curriculumData.faculty_title}
                  </Typography>
                  <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
                    <Chip 
                      label={`${curriculumData.version} Curriculum`} 
                      sx={{ 
                        backgroundColor: 'rgba(255,255,255,0.2)', 
                        color: 'white',
                        fontWeight: 'bold',
                        fontSize: '0.9rem'
                      }} 
                    />
                    <Typography variant="body2" sx={{ opacity: 0.8 }}>
                      {curriculumData.department.name} • Faculty: {curriculumData.faculty_title}
                    </Typography>
                  </Box>
                </Grid>
              </Grid>
            </CardContent>
          </Card>

          {/* Search and Filter Section */}
          <Card sx={{ mb: 4 }}>
            <CardContent>
              <Typography variant="h6" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                <FilterList /> Search & Filter Courses
              </Typography>
              
              {/* Search Bar */}
              <TextField
                fullWidth
                variant="outlined"
                placeholder="Search by course code, title, or category..."
                value={searchTerm}
                onChange={handleSearchChange}
                sx={{ mb: 2 }}
                InputProps={{
                  startAdornment: (
                    <InputAdornment position="start">
                      <Search />
                    </InputAdornment>
                  ),
                  endAdornment: searchTerm && (
                    <InputAdornment position="end">
                      <IconButton onClick={() => setSearchTerm('')} size="small">
                        <Clear />
                      </IconButton>
                    </InputAdornment>
                  )
                }}
              />

              {/* Filters */}
              <Grid container spacing={2} sx={{ mb: 2 }}>
                <Grid item xs={12} sm={6} lg={2.4}>
                  <FormControl fullWidth size="small">
                    <InputLabel>Category</InputLabel>
                    <Select
                      value={searchFilters.category}
                      onChange={(e) => handleFilterChange('category', e.target.value)}
                      label="Category"
                    >
                      <MenuItem value="">All Categories</MenuItem>
                      {Object.entries(CATEGORY_NAMES).map(([key, name]) => (
                        <MenuItem key={key} value={key}>{name}</MenuItem>
                      ))}
                    </Select>
                  </FormControl>
                </Grid>
                
                <Grid item xs={12} sm={6} lg={2.4}>
                  <FormControl fullWidth size="small">
                    <InputLabel>Semester</InputLabel>
                    <Select
                      value={searchFilters.semester}
                      onChange={(e) => handleFilterChange('semester', e.target.value)}
                      label="Semester"
                    >
                      <MenuItem value="">All Semesters</MenuItem>
                      {curriculumData.all_courses && 
                        getUniqueValues(curriculumData.all_courses, 'semester').map(semester => (
                          <MenuItem key={semester} value={semester}>
                            {semester === 'Elective' ? 'Elective' : getSemesterDisplayName(semester)}
                          </MenuItem>
                        ))
                      }
                    </Select>
                  </FormControl>
                </Grid>

                <Grid item xs={12} sm={6} lg={2.4}>
                  <FormControl fullWidth size="small">
                    <InputLabel>Credits</InputLabel>
                    <Select
                      value={searchFilters.credits}
                      onChange={(e) => handleFilterChange('credits', e.target.value)}
                      label="Credits"
                    >
                      <MenuItem value="">All Credits</MenuItem>
                      {curriculumData.all_courses && 
                        getUniqueValues(curriculumData.all_courses, 'credits').map(credits => (
                          <MenuItem key={credits} value={credits.toString()}>
                            {credits} Credits
                          </MenuItem>
                        ))
                      }
                    </Select>
                  </FormControl>
                </Grid>

                <Grid item xs={12} sm={6} lg={2.4}>
                  <Button
                    variant="outlined"
                    startIcon={<Clear />}
                    onClick={clearAllFilters}
                    disabled={!hasActiveFilters()}
                    fullWidth
                    size="small"
                  >
                    Clear Filters
                  </Button>
                </Grid>
              </Grid>

              {/* Active Filters Display */}
              {hasActiveFilters() && (
                <Box sx={{ display: 'flex', gap: 1, flexWrap: 'wrap', alignItems: 'center' }}>
                  <Typography variant="body2" color="text.secondary">
                    Active filters:
                  </Typography>
                  {searchTerm && (
                    <Chip 
                      label={`Search: "${searchTerm}"`} 
                      onDelete={() => setSearchTerm('')}
                      size="small"
                      color="primary"
                    />
                  )}
                  {searchFilters.category && (
                    <Chip 
                      label={`Category: ${getCategoryName(searchFilters.category)}`} 
                      onDelete={() => handleFilterChange('category', '')}
                      size="small"
                      color="primary"
                    />
                  )}
                  {searchFilters.semester && (
                    <Chip 
                      label={`Semester: ${getSemesterDisplayName(searchFilters.semester)}`} 
                      onDelete={() => handleFilterChange('semester', '')}
                      size="small"
                      color="primary"
                    />
                  )}
                  {searchFilters.credits && (
                    <Chip 
                      label={`Credits: ${searchFilters.credits}`} 
                      onDelete={() => handleFilterChange('credits', '')}
                      size="small"
                      color="primary"
                    />
                  )}
                </Box>
              )}
            </CardContent>
          </Card>

          {/* Statistics Cards */}
          <Grid container spacing={2} sx={{ mb: 4 }}>
            <Grid item xs={12} sm={6} md={2.4}>
              <StatCard
                title="Curriculum Version"
                value={curriculumData.version}
                subtitle="Current Version"
                icon={Timeline}
                isLoading={loading}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={2.4}>
              <StatCard
                title="Core Courses"
                value={getNonElectiveStats.totalCourses}
                subtitle="Semester courses only"
                icon={MenuBook}
                isLoading={loading}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={2.4}>
              <StatCard
                title="Core Credits"
                value={getNonElectiveStats.totalCredits}
                subtitle="Semester credits only"
                icon={Assessment}
                isLoading={loading}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={2.4}>
              <StatCard
                title="Core ECTS"
                value={getNonElectiveStats.totalEcts}
                subtitle="Semester ECTS only"
                icon={Category}
                isLoading={loading}
              />
            </Grid>
            <Grid item xs={12} sm={6} md={2.4}>
              <StatCard
                title="Avg Credits/Course"
                value={
                  getNonElectiveStats.totalCourses > 0 
                    ? (getNonElectiveStats.totalCredits / getNonElectiveStats.totalCourses).toFixed(2)
                    : 0
                }
                subtitle="Core courses average"
                icon={School}
                isLoading={loading}
              />
            </Grid>
          </Grid>

          {/* Tabs for different views */}
          <Card>
            <Box sx={{ borderBottom: 1, borderColor: 'divider', backgroundColor: '#f8f9fa' }}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', px: 2, py: 1 }}>
                <Tabs value={tabValue} onChange={handleTabChange} aria-label="curriculum tabs">
                  <Tab label="By Semester" />
                  <Tab label="By Category" />
                  <Tab label="All Courses" />
                  <Tab label="Statistics" />
                </Tabs>
                <Typography variant="body2" color="text.secondary" sx={{ fontWeight: 'bold' }}>
                  {curriculumData.version} Curriculum
                </Typography>
              </Box>
            </Box>

            {/* By Semester Tab */}
            <TabPanel value={tabValue} index={0}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
                <Typography variant="h6" gutterBottom>
                  Courses by Semester
                </Typography>
                <Box sx={{ display: 'flex', gap: 1, alignItems: 'center' }}>
                  {hasActiveFilters() && (
                    <Typography variant="body2" color="text.secondary">
                      {filteredCourses.length} of {curriculumData.all_courses.length} courses
                    </Typography>
                  )}
                  <Chip 
                    label={`${curriculumData.version} Curriculum`} 
                    color="primary" 
                    variant="outlined"
                    sx={{ fontWeight: 'bold' }}
                  />
                </Box>
              </Box>
              {getFilteredSemesters(getSortedSemesters(curriculumData.courses_by_semester)).length === 0 ? (
                <Alert severity="info">
                  No courses found matching your search criteria.
                </Alert>
              ) : (
                getFilteredSemesters(getSortedSemesters(curriculumData.courses_by_semester)).map((semester) => (
                  <Accordion key={semester.semester} defaultExpanded={true} sx={{ mb: 2 }}>
                    <AccordionSummary expandIcon={<ExpandMore />}>
                      <Box sx={{ display: 'flex', alignItems: 'center', width: '100%' }}>
                        <Typography variant="h6" sx={{ flexGrow: 1, fontWeight: 'bold', color: '#1976d2' }}>
                          {getSemesterDisplayName(semester.semester)}
                        </Typography>
                        <Stack direction="row" spacing={1} sx={{ mr: 2 }}>
                          <Badge badgeContent={semester.courses.length} color="primary">
                            <Chip label="Courses" size="small" variant="outlined" />
                          </Badge>
                          <Badge badgeContent={semester.courses.reduce((sum, course) => sum + course.credits, 0)} color="secondary">
                            <Chip label="Credits" size="small" variant="outlined" />
                          </Badge>
                          <Badge badgeContent={semester.courses.reduce((sum, course) => sum + course.ects, 0)} color="success">
                            <Chip label="ECTS" size="small" variant="outlined" />
                          </Badge>
                        </Stack>
                      </Box>
                    </AccordionSummary>
                    <AccordionDetails>
                      <CourseTable courses={getSortedCourses(semester.courses)} />
                    </AccordionDetails>
                  </Accordion>
                ))
              )}
            </TabPanel>

            {/* By Category Tab */}
            <TabPanel value={tabValue} index={1}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
                <Typography variant="h6" gutterBottom>
                  Courses by Category
                </Typography>
                {hasActiveFilters() && (
                  <Typography variant="body2" color="text.secondary">
                    {filteredCourses.length} of {curriculumData.all_courses.length} courses
                  </Typography>
                )}
              </Box>
              {getFilteredCategories(curriculumData.courses_by_category).length === 0 ? (
                <Alert severity="info">
                  No courses found matching your search criteria.
                </Alert>
              ) : (
                getFilteredCategories(curriculumData.courses_by_category).map((category) => (
                  <Accordion key={category.category} sx={{ mb: 2 }}>
                    <AccordionSummary expandIcon={<ExpandMore />}>
                      <Box sx={{ display: 'flex', alignItems: 'center', width: '100%' }}>
                        <Typography variant="h6" sx={{ flexGrow: 1 }}>
                          {category.category_name}
                        </Typography>
                        <Stack direction="row" spacing={1}>
                          <Badge badgeContent={category.courses.length} color="primary">
                            <Chip label="Courses" size="small" />
                          </Badge>
                          <Badge badgeContent={category.courses.reduce((sum, course) => sum + course.credits, 0)} color="secondary">
                            <Chip label="Credits" size="small" />
                          </Badge>
                          <Badge badgeContent={category.courses.reduce((sum, course) => sum + course.ects, 0)} color="success">
                            <Chip label="ECTS" size="small" />
                          </Badge>
                        </Stack>
                      </Box>
                    </AccordionSummary>
                    <AccordionDetails>
                      <CourseTable courses={category.courses} showSemester={true} />
                    </AccordionDetails>
                  </Accordion>
                ))
              )}
            </TabPanel>

            {/* All Courses Tab */}
            <TabPanel value={tabValue} index={2}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
                <Typography variant="h6" gutterBottom>
                  All Courses (Sorted by Semester & Category)
                </Typography>
                {hasActiveFilters() && (
                  <Typography variant="body2" color="text.secondary">
                    Showing {filteredCourses.length} of {curriculumData.all_courses.length} courses
                  </Typography>
                )}
              </Box>
              {filteredCourses.length === 0 ? (
                <Alert severity="info">
                  No courses found matching your search criteria.
                </Alert>
              ) : (
                <CourseTable courses={getSortedAllCourses(filteredCourses)} showSemester={true} />
              )}
            </TabPanel>

            {/* Statistics Tab */}
            <TabPanel value={tabValue} index={3}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
                <Typography variant="h6" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                  <BarChart /> Curriculum Statistics & Analytics
                </Typography>
                <Box sx={{ display: 'flex', gap: 1 }}>
                  <Chip 
                    label={`${curriculumData.version} Version`} 
                    color="primary" 
                    variant="outlined"
                    sx={{ fontWeight: 'bold' }}
                  />
                  <Chip 
                    label={`${curriculumData.department.name}`} 
                    color="secondary" 
                    variant="outlined"
                    size="small"
                  />
                </Box>
              </Box>
              
              {/* Charts Grid */}
              <Grid container spacing={3}>
                <Grid item xs={12} md={6} lg={4}>
                  <Card sx={{ height: '420px' }}>
                    <CardContent sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                      <Typography variant="h6" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                        <PieChart /> Core Course Distribution by Category
                      </Typography>
                      <Box sx={{ flexGrow: 1 }}>
                        <ResponsiveContainer width="100%" height="100%">
                          <RechartsPieChart>
                            <Pie
                              data={prepareCategoryChartData}
                              cx="50%"
                              cy="50%"
                              labelLine={false}
                              label={renderCustomizedLabel}
                              outerRadius={80}
                              fill="#8884d8"
                              dataKey="value"
                            >
                              {prepareCategoryChartData.map((entry, index) => (
                                <Cell key={`cell-${index}`} fill={entry.color} />
                              ))}
                            </Pie>
                            <Tooltip content={<CustomTooltip />} />
                            <Legend />
                          </RechartsPieChart>
                        </ResponsiveContainer>
                      </Box>
                    </CardContent>
                  </Card>
                </Grid>

                <Grid item xs={12} md={6} lg={4}>
                  <Card sx={{ height: '420px' }}>
                    <CardContent sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                      <Typography variant="h6" gutterBottom>
                        Core Credits vs ECTS by Semester
                      </Typography>
                      <Box sx={{ flexGrow: 1 }}>
                        <ResponsiveContainer width="100%" height="100%">
                          <RechartsBarChart data={prepareSemesterChartData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="semester" />
                            <YAxis />
                            <Tooltip content={<CustomTooltip />} />
                            <Bar dataKey="credits" fill="#2e7d32" name="Credits" />
                            <Bar dataKey="ects" fill="#ed6c02" name="ECTS" />
                            <Legend />
                          </RechartsBarChart>
                        </ResponsiveContainer>
                      </Box>
                    </CardContent>
                  </Card>
                </Grid>

                <Grid item xs={12} md={6} lg={4}>
                  <Card sx={{ height: '420px' }}>
                    <CardContent sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
                      <Typography variant="h6" gutterBottom>
                        Cumulative Core Academic Progress
                      </Typography>
                      <Box sx={{ flexGrow: 1 }}>
                        <ResponsiveContainer width="100%" height="100%">
                          <AreaChart data={prepareCumulativeData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="semester" />
                            <YAxis />
                            <Tooltip content={<CustomTooltip />} />
                            <Area 
                              type="monotone" 
                              dataKey="cumulativeCredits" 
                              stackId="1" 
                              stroke="#1976d2" 
                              fill="#1976d2" 
                              fillOpacity={0.6}
                              name="Cumulative Credits"
                            />
                            <Area 
                              type="monotone" 
                              dataKey="cumulativeEcts" 
                              stackId="2" 
                              stroke="#2e7d32" 
                              fill="#2e7d32" 
                              fillOpacity={0.6}
                              name="Cumulative ECTS"
                            />
                            <Legend />
                          </AreaChart>
                        </ResponsiveContainer>
                      </Box>
                    </CardContent>
                  </Card>
                </Grid>
              </Grid>

              <Divider sx={{ my: 4 }} />

              {/* Detailed Statistics Tables */}
              <Typography variant="h6" gutterBottom sx={{ mt: 4, mb: 3 }}>
                Detailed Breakdown
              </Typography>
              
              <Grid container spacing={2}>
                <Grid item xs={12} lg={6}>
                  <Card>
                    <CardContent>
                      <Typography variant="h6" gutterBottom>
                        Category Breakdown (Core Courses Only)
                      </Typography>
                      <Divider sx={{ mb: 2 }} />
                      {prepareCategoryChartData.map((cat) => (
                        <Box key={cat.name} sx={{ mb: 2 }}>
                          <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 1 }}>
                            <Typography variant="body1" sx={{ fontWeight: 'bold' }}>
                              {cat.name}
                            </Typography>
                            <Chip 
                              label={`${cat.value} courses`} 
                              size="small" 
                              sx={{ 
                                backgroundColor: cat.color + '20',
                                color: cat.color
                              }}
                            />
                          </Box>
                          <Typography variant="body2" color="text.secondary">
                            Credits: {cat.credits} | ECTS: {cat.ects}
                          </Typography>
                          <Box sx={{ 
                            width: '100%', 
                            height: 8, 
                            backgroundColor: '#f0f0f0', 
                            borderRadius: 4, 
                            mt: 1 
                          }}>
                            <Box sx={{ 
                              width: `${cat.percentage}%`,
                              height: '100%',
                              backgroundColor: cat.color,
                              borderRadius: 4
                            }} />
                          </Box>
                        </Box>
                      ))}
                    </CardContent>
                  </Card>
                </Grid>

                <Grid item xs={12} lg={6}>
                  <Card>
                    <CardContent>
                      <Typography variant="h6" gutterBottom>
                        Semester Breakdown (Core Courses Only)
                      </Typography>
                      <Divider sx={{ mb: 2 }} />
                      {curriculumData.statistics.semester_breakdown
                        .filter(sem => sem.semester !== 'Elective')
                        .sort((a, b) => compareSemesters(a.semester, b.semester))
                        .map((sem) => (
                        <Box key={sem.semester} sx={{ mb: 2 }}>
                          <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 1 }}>
                            <Typography variant="body1" sx={{ fontWeight: 'bold' }}>
                              {getSemesterDisplayName(sem.semester)}
                            </Typography>
                            <Chip 
                              label={`${sem.count} courses`} 
                              size="small" 
                              variant="outlined"
                            />
                          </Box>
                          <Typography variant="body2" color="text.secondary">
                            Credits: {sem.credits} | ECTS: {sem.ects}
                          </Typography>
                          <Box sx={{ 
                            width: '100%', 
                            height: 8, 
                            backgroundColor: '#f0f0f0', 
                            borderRadius: 4, 
                            mt: 1 
                          }}>
                            <Box sx={{ 
                              width: `${(sem.count / getNonElectiveStats.totalCourses) * 100}%`,
                              height: '100%',
                              backgroundColor: '#1976d2',
                              borderRadius: 4
                            }} />
                          </Box>
                        </Box>
                      ))}
                      
                      {/* Separate section for Elective Courses info */}
                      {curriculumData.statistics.semester_breakdown.find(sem => sem.semester === 'Elective') && (
                        <Box sx={{ mt: 4, p: 2, backgroundColor: '#f8f9fa', borderRadius: 1 }}>
                          <Typography variant="subtitle2" sx={{ fontWeight: 'bold', color: '#666', mb: 1 }}>
                            Additional Information
                          </Typography>
                          <Typography variant="body2" color="text.secondary">
                            Elective Courses Available: {curriculumData.statistics.semester_breakdown.find(sem => sem.semester === 'Elective').count}
                          </Typography>
                          <Typography variant="caption" color="text.secondary" sx={{ fontStyle: 'italic' }}>
                            (Electives are excluded from core curriculum calculations)
                          </Typography>
                        </Box>
                      )}
                    </CardContent>
                  </Card>
                </Grid>
              </Grid>
            </TabPanel>
          </Card>
        </Box>
      )}
    </Box>
  );
}

export default CurriculumPage;