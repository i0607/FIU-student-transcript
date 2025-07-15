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
  Skeleton,
  Snackbar,
  Tooltip,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TablePagination
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
  Refresh,
  Download,
  Print,
  Info,
  Visibility,
  VisibilityOff,
  FileDownload,
  Analytics
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
  Tooltip as RechartsTooltip,
  Legend,
  ResponsiveContainer,
  Area,
  AreaChart,
  LineChart,
  Line
} from 'recharts';
import axios from 'axios';

// =============================================================================
// CONSTANTS & CONFIGURATION
// =============================================================================

const API_CONFIG = {
  baseURL: process.env.REACT_APP_API_URL || 'http://localhost:8000/api',
  timeout: 10000,
  retryAttempts: 3,
  retryDelay: 1000
};

const CATEGORY_COLORS = {
  'AC': '#1976d2', 'AE': '#388e3c', 'UC': '#f57c00',
  'FC': '#7b1fa2', 'FE': '#c2185b', 'UE': '#5d4037',
  'Others': '#616161'
};

const CATEGORY_NAMES = {
  'AC': 'Area Core', 'AE': 'Area Elective', 'UC': 'University Core',
  'FC': 'Faculty Core', 'FE': 'Faculty Elective', 'UE': 'University Elective'
};

const CATEGORY_PRIORITY = {
  'AC': 1, 'FC': 2, 'UC': 3, 'AE': 4, 'FE': 5, 'UE': 6
};

const STAT_CARD_CONFIGS = [
  { key: 'version', title: 'Curriculum Version', icon: Timeline, color: '#b91c1c', bgColor: '#fef2f2' },
  { key: 'courses', title: 'Core Courses', icon: MenuBook, color: '#059669', bgColor: '#ecfdf5' },
  { key: 'credits', title: 'Core Credits', icon: Assessment, color: '#2563eb', bgColor: '#eff6ff' },
  { key: 'ects', title: 'Core ECTS', icon: Category, color: '#7c3aed', bgColor: '#f3e8ff' },
  { key: 'average', title: 'Avg Credits/Course', icon: School, color: '#ea580c', bgColor: '#fff7ed' }
];

// =============================================================================
// UTILITY FUNCTIONS
// =============================================================================

const getCategoryColor = (category) => CATEGORY_COLORS[category] || CATEGORY_COLORS['Others'];
const getCategoryName = (category) => CATEGORY_NAMES[(category || '').toUpperCase()] || 'Others';

const compareSemesters = (a, b) => {
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
};

const getSemesterDisplayName = (semester) => {
  if (!semester || semester === 'Elective' || semester.toString().toLowerCase() === 'elective') {
    return 'Elective Courses';
  }
  if (typeof semester === 'number') {
    return `Semester ${semester}`;
  }
  if (typeof semester === 'string') {
    if (semester.toLowerCase().includes('semester')) return semester;
    if (/^\d+$/.test(semester.trim())) return `Semester ${semester}`;
    return semester;
  }
  return `Semester ${semester}`;
};

const debounce = (func, wait) => {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
};

const exportToCSV = (data, filename) => {
  const csvContent = [
    Object.keys(data[0]).join(','),
    ...data.map(row => Object.values(row).join(','))
  ].join('\n');
  
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const link = document.createElement('a');
  const url = URL.createObjectURL(blob);
  link.setAttribute('href', url);
  link.setAttribute('download', filename);
  link.style.visibility = 'hidden';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

// =============================================================================
// CUSTOM HOOKS
// =============================================================================

const useAPIWithRetry = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const apiCall = useCallback(async (url, options = {}) => {
    setLoading(true);
    setError(null);
    
    const makeRequest = async (attempt = 1) => {
      try {
        const response = await axios({
          url: `${API_CONFIG.baseURL}${url}`,
          method: 'GET',
          timeout: API_CONFIG.timeout,
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json'
          },
          ...options
        });
        
        if (!response.data.success) {
          throw new Error(response.data.message || 'API request failed');
        }
        
        return response.data.data;
      } catch (err) {
        if (attempt < API_CONFIG.retryAttempts && err.code !== 'ECONNABORTED') {
          await new Promise(resolve => setTimeout(resolve, API_CONFIG.retryDelay * attempt));
          return makeRequest(attempt + 1);
        }
        throw err;
      }
    };

    try {
      const result = await makeRequest();
      return result;
    } catch (err) {
      const errorMessage = getErrorMessage(err);
      setError(errorMessage);
      throw err;
    } finally {
      setLoading(false);
    }
  }, []);

  const getErrorMessage = useCallback((err) => {
    if (err.code === 'ECONNABORTED') {
      return 'Request timeout. Please check your connection and try again.';
    }
    if (err.response?.status === 401) {
      return 'Unauthorized access. Please login again.';
    }
    if (err.response?.status === 403) {
      return 'Access denied. You don\'t have permission to view this data.';
    }
    if (err.response?.status >= 500) {
      return 'Server error. Please try again later.';
    }
    if (err.response?.data?.message) {
      return err.response.data.message;
    }
    return 'An unexpected error occurred. Please try again.';
  }, []);

  return { apiCall, loading, error, setError };
};

const useCurriculumData = () => {
  const { apiCall, loading, error, setError } = useAPIWithRetry();
  const [departments, setDepartments] = useState([]);
  const [curriculumData, setCurriculumData] = useState(null);
  const [cache, setCache] = useState(new Map());

  const fetchDepartments = useCallback(async () => {
    try {
      const cacheKey = 'departments';
      if (cache.has(cacheKey)) {
        setDepartments(cache.get(cacheKey));
        return;
      }

      const data = await apiCall('/curriculum/departments');
      setDepartments(data.departments);
      setCache(prev => new Map(prev).set(cacheKey, data.departments));
    } catch (err) {
      console.error('Error fetching departments:', err);
    }
  }, [apiCall, cache]);

  const fetchCurriculumData = useCallback(async (departmentId, version) => {
    try {
      const cacheKey = `curriculum-${departmentId}-${version}`;
      if (cache.has(cacheKey)) {
        setCurriculumData(cache.get(cacheKey));
        return;
      }

      const data = await apiCall('/curriculum/search', {
        params: { department_id: departmentId, version }
      });
      setCurriculumData(data);
      setCache(prev => new Map(prev).set(cacheKey, data));
    } catch (err) {
      setCurriculumData(null);
      console.error('Error fetching curriculum data:', err);
    }
  }, [apiCall, cache]);

  const clearCache = useCallback(() => {
    setCache(new Map());
  }, []);

  return {
    departments,
    curriculumData,
    fetchDepartments,
    fetchCurriculumData,
    clearCache,
    loading,
    error,
    setError
  };
};

const useSearchAndFilter = (courses) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [filters, setFilters] = useState({
    category: '',
    semester: '',
    credits: ''
  });
  const [debouncedSearchTerm, setDebouncedSearchTerm] = useState('');

  // Debounce search term
  const debouncedSetSearch = useCallback(
    debounce((term) => setDebouncedSearchTerm(term), 300),
    []
  );

  useEffect(() => {
    debouncedSetSearch(searchTerm);
  }, [searchTerm, debouncedSetSearch]);

  const filteredCourses = useMemo(() => {
    if (!courses) return [];
    
    return courses.filter(course => {
      const matchesSearch = !debouncedSearchTerm || 
        course.code.toLowerCase().includes(debouncedSearchTerm.toLowerCase()) ||
        course.title.toLowerCase().includes(debouncedSearchTerm.toLowerCase()) ||
        course.category_name.toLowerCase().includes(debouncedSearchTerm.toLowerCase()) ||
        (course.equivalent_courses && course.equivalent_courses.some(eq => 
          eq.code.toLowerCase().includes(debouncedSearchTerm.toLowerCase()) ||
          eq.title.toLowerCase().includes(debouncedSearchTerm.toLowerCase())
        ));

      const matchesCategory = !filters.category || course.category === filters.category;
      const matchesSemester = !filters.semester || course.semester === filters.semester;
      const matchesCredits = !filters.credits || course.credits.toString() === filters.credits;

      return matchesSearch && matchesCategory && matchesSemester && matchesCredits;
    });
  }, [courses, debouncedSearchTerm, filters]);

  const hasActiveFilters = useMemo(() => {
    return debouncedSearchTerm || filters.category || filters.semester || filters.credits;
  }, [debouncedSearchTerm, filters]);

  const clearFilters = useCallback(() => {
    setSearchTerm('');
    setDebouncedSearchTerm('');
    setFilters({ category: '', semester: '', credits: '' });
  }, []);

  const updateFilter = useCallback((filterType, value) => {
    setFilters(prev => ({ ...prev, [filterType]: value }));
  }, []);

  return {
    searchTerm,
    setSearchTerm,
    debouncedSearchTerm,
    filters,
    updateFilter,
    filteredCourses,
    hasActiveFilters,
    clearFilters
  };
};

const usePagination = (data, itemsPerPage = 10) => {
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(itemsPerPage);

  const paginatedData = useMemo(() => {
    const startIndex = page * rowsPerPage;
    return data.slice(startIndex, startIndex + rowsPerPage);
  }, [data, page, rowsPerPage]);

  const handleChangePage = useCallback((event, newPage) => {
    setPage(newPage);
  }, []);

  const handleChangeRowsPerPage = useCallback((event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  }, []);

  return {
    page,
    rowsPerPage,
    paginatedData,
    handleChangePage,
    handleChangeRowsPerPage
  };
};

// =============================================================================
// COMPONENT DEFINITIONS
// =============================================================================

const TabPanel = ({ children, value, index, ...other }) => (
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

const StatCard = ({ title, value, subtitle, icon: Icon, isLoading = false, color = '#b91c1c', bgColor = '#fef2f2' }) => (
  <Card sx={{ 
    height: '100%', 
    display: 'flex', 
    flexDirection: 'column',
    borderRadius: 3,
    boxShadow: '0 4px 20px rgba(0,0,0,0.08)',
    border: `2px solid ${color}20`,
    background: `linear-gradient(135deg, ${bgColor} 0%, #ffffff 100%)`,
    transition: 'all 0.3s ease',
    '&:hover': {
      transform: 'translateY(-4px)',
      boxShadow: `0 8px 25px ${color}30`
    }
  }}>
    <CardContent sx={{ flexGrow: 1, p: 3 }}>
      <Box sx={{ display: 'flex', alignItems: 'center', mb: 2 }}>
        <Box sx={{
          backgroundColor: color,
          borderRadius: '12px',
          p: 1.5,
          mr: 2,
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center'
        }}>
          <Icon sx={{ color: 'white', fontSize: 24 }} />
        </Box>
        <Typography variant="h6" component="div" sx={{ fontWeight: 'bold', color: '#1e293b' }}>
          {title}
        </Typography>
      </Box>
      {isLoading ? (
        <Skeleton variant="text" width="60%" height={40} />
      ) : (
        <Typography variant="h3" sx={{ 
          fontWeight: 'bold', 
          color: color, 
          mb: 1,
          fontSize: { xs: '1.8rem', sm: '2.2rem' }
        }}>
          {value}
        </Typography>
      )}
      {subtitle && !isLoading && (
        <Typography variant="body2" sx={{ color: '#64748b', fontWeight: 500 }}>
          {subtitle}
        </Typography>
      )}
    </CardContent>
  </Card>
);

const CourseTable = ({ courses, showSemester = false, compactView = false }) => {
  const { page, rowsPerPage, paginatedData, handleChangePage, handleChangeRowsPerPage } = usePagination(courses);
  const [selectedCourse, setSelectedCourse] = useState(null);

  const formatEquivalentCourses = (course) => {
    if (!course.equivalent_courses || course.equivalent_courses.length === 0) {
      return course.code;
    }
    const allCodes = [course.code, ...course.equivalent_courses.map(eq => eq.code)];
    return allCodes.join(' / ');
  };

  const formatCourseTitles = (course) => {
    if (!course.equivalent_courses || course.equivalent_courses.length === 0) {
      return course.title;
    }
    
    if (compactView) {
      return `${course.title} (+${course.equivalent_courses.length})`;
    }
    
    const equivalentTitles = course.equivalent_courses
      .map(eq => eq.title)
      .filter(title => title !== course.title);
    
    if (equivalentTitles.length === 0) {
      return course.title;
    }
    
    return `${course.title} (${equivalentTitles.join(' / ')})`;
  };

  const handleRowClick = (course) => {
    setSelectedCourse(course);
  };

  return (
    <Box>
      <TableContainer component={Paper} sx={{ mt: 2, maxHeight: 600 }}>
        <Table stickyHeader size={compactView ? "small" : "medium"}>
          <TableHead>
            <TableRow sx={{ backgroundColor: '#f5f5f5' }}>
              <TableCell><strong>Course Code(s)</strong></TableCell>
              <TableCell><strong>Course Title(s)</strong></TableCell>
              <TableCell align="center"><strong>Credits</strong></TableCell>
              <TableCell align="center"><strong>ECTS</strong></TableCell>
              <TableCell><strong>Category</strong></TableCell>
              {showSemester && <TableCell align="center"><strong>Semester</strong></TableCell>}
              {!compactView && <TableCell><strong>Prerequisites</strong></TableCell>}
              <TableCell align="center"><strong>Actions</strong></TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {paginatedData.map((course) => (
              <TableRow 
                key={course.course_id} 
                hover 
                sx={{ 
                  cursor: 'pointer',
                  '&:hover': {
                    backgroundColor: '#f8f9fa'
                  }
                }}
                onClick={() => handleRowClick(course)}
              >
                <TableCell>
                  <Typography 
                    variant="body2" 
                    sx={{ 
                      fontWeight: 'bold', 
                      color: '#1976d2',
                      fontSize: compactView ? '0.8rem' : '0.875rem'
                    }}
                  >
                    {formatEquivalentCourses(course)}
                  </Typography>
                  {!compactView && course.equivalent_courses && course.equivalent_courses.length > 0 && (
                    <Typography 
                      variant="caption" 
                      sx={{ 
                        display: 'block',
                        color: '#666',
                        fontStyle: 'italic',
                        mt: 0.5
                      }}
                    >
                      ({course.equivalent_courses.length} equivalent{course.equivalent_courses.length > 1 ? 's' : ''})
                    </Typography>
                  )}
                </TableCell>
                <TableCell>
                  <Typography 
                    variant="body2" 
                    sx={{ fontSize: compactView ? '0.8rem' : '0.875rem' }}
                  >
                    {formatCourseTitles(course)}
                  </Typography>
                </TableCell>
                <TableCell align="center">
                  <Chip 
                    label={course.credits} 
                    size="small" 
                    sx={{ 
                      backgroundColor: '#e3f2fd', 
                      color: '#1976d2',
                      fontSize: compactView ? '0.7rem' : '0.8rem'
                    }}
                  />
                </TableCell>
                <TableCell align="center">
                  <Chip 
                    label={course.ects} 
                    size="small" 
                    sx={{ 
                      backgroundColor: '#e8f5e8', 
                      color: '#2e7d32',
                      fontSize: compactView ? '0.7rem' : '0.8rem'
                    }}
                  />
                </TableCell>
                <TableCell>
                  <Chip 
                    label={compactView ? course.category : course.category_name} 
                    size="small" 
                    sx={{ 
                      backgroundColor: getCategoryColor(course.category) + '20',
                      color: getCategoryColor(course.category),
                      fontWeight: 'bold',
                      fontSize: compactView ? '0.7rem' : '0.8rem'
                    }}
                  />
                </TableCell>
                {showSemester && (
                  <TableCell align="center">
                    <Chip 
                      label={compactView ? 
                        (course.semester === 'Elective' ? 'Elec' : `S${course.semester}`) : 
                        getSemesterDisplayName(course.semester)
                      } 
                      size="small" 
                      variant="outlined"
                      sx={{ fontSize: compactView ? '0.7rem' : '0.8rem' }}
                    />
                  </TableCell>
                )}
                {!compactView && (
                  <TableCell>
                    <Typography variant="body2" color="text.secondary">
                      {course.pre_requisite || 'None'}
                    </Typography>
                  </TableCell>
                )}
                <TableCell align="center">
                  <Tooltip title="View Details">
                    <IconButton 
                      size="small" 
                      onClick={(e) => {
                        e.stopPropagation();
                        handleRowClick(course);
                      }}
                    >
                      <Info fontSize="small" />
                    </IconButton>
                  </Tooltip>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
      
      <TablePagination
        component="div"
        count={courses.length}
        page={page}
        onPageChange={handleChangePage}
        rowsPerPage={rowsPerPage}
        onRowsPerPageChange={handleChangeRowsPerPage}
        rowsPerPageOptions={[10, 25, 50, 100]}
        sx={{ mt: 2 }}
      />

      {/* Course Details Dialog */}
      <Dialog 
        open={!!selectedCourse} 
        onClose={() => setSelectedCourse(null)}
        maxWidth="md"
        fullWidth
      >
        <DialogTitle>
          <Typography variant="h6" component="div">
            Course Details
          </Typography>
        </DialogTitle>
        <DialogContent>
          {selectedCourse && (
            <Grid container spacing={2}>
              <Grid item xs={12} sm={6}>
                <Typography variant="subtitle2" color="text.secondary">Course Code</Typography>
                <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 2 }}>
                  {formatEquivalentCourses(selectedCourse)}
                </Typography>
              </Grid>
              <Grid item xs={12} sm={6}>
                <Typography variant="subtitle2" color="text.secondary">Category</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {selectedCourse.category_name}
                </Typography>
              </Grid>
              <Grid item xs={12}>
                <Typography variant="subtitle2" color="text.secondary">Course Title</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {selectedCourse.title}
                </Typography>
              </Grid>
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle2" color="text.secondary">Credits</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {selectedCourse.credits}
                </Typography>
              </Grid>
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle2" color="text.secondary">ECTS</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {selectedCourse.ects}
                </Typography>
              </Grid>
              <Grid item xs={12} sm={4}>
                <Typography variant="subtitle2" color="text.secondary">Semester</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {getSemesterDisplayName(selectedCourse.semester)}
                </Typography>
              </Grid>
              <Grid item xs={12}>
                <Typography variant="subtitle2" color="text.secondary">Prerequisites</Typography>
                <Typography variant="body1" sx={{ mb: 2 }}>
                  {selectedCourse.pre_requisite || 'None'}
                </Typography>
              </Grid>
              {selectedCourse.equivalent_courses && selectedCourse.equivalent_courses.length > 0 && (
                <Grid item xs={12}>
                  <Typography variant="subtitle2" color="text.secondary">Equivalent Courses</Typography>
                  <Box sx={{ mt: 1 }}>
                    {selectedCourse.equivalent_courses.map((eq, index) => (
                      <Chip 
                        key={index}
                        label={`${eq.code} - ${eq.title}`}
                        size="small"
                        sx={{ mr: 1, mb: 1 }}
                      />
                    ))}
                  </Box>
                </Grid>
              )}
            </Grid>
          )}
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setSelectedCourse(null)}>Close</Button>
        </DialogActions>
      </Dialog>
    </Box>
  );
};

const EnhancedSearchAndFilter = ({ 
  searchTerm, 
  setSearchTerm, 
  filters, 
  updateFilter, 
  clearFilters, 
  hasActiveFilters, 
  courses,
  compactView,
  setCompactView
}) => {
  const getUniqueValues = (field) => {
    if (!courses) return [];
    const values = [...new Set(courses.map(course => course[field]))];
    if (field === 'semester') {
      return values.filter(value => value && value !== 'Elective').sort(compareSemesters);
    }
    return values.filter(value => value && value !== 'Elective').sort();
  };

  const handleExportFiltered = () => {
    if (!courses || courses.length === 0) return;
    
    const exportData = courses.map(course => ({
      code: course.code,
      title: course.title,
      credits: course.credits,
      ects: course.ects,
      category: course.category_name,
      semester: getSemesterDisplayName(course.semester),
      prerequisites: course.pre_requisite || 'None'
    }));
    
    exportToCSV(exportData, 'filtered-courses.csv');
  };

  return (
    <Card sx={{ 
      mb: 4,
      borderRadius: 2,
      boxShadow: '0 2px 12px rgba(0,0,0,0.06)',
      backgroundColor: '#ffffff',
      border: '1px solid #e2e8f0'
    }}>
      <CardContent sx={{ p: 4 }}>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
            <FilterList sx={{ color: '#64748b' }} />
            <Typography variant="h6" sx={{ color: '#1e293b', fontWeight: 600 }}>
              Search & Filter Courses
            </Typography>
          </Box>
          <Box sx={{ display: 'flex', gap: 2 }}>
            <FormControl size="small" sx={{ minWidth: 140 }}>
              <InputLabel sx={{ color: '#64748b' }}>View</InputLabel>
              <Select
                value={compactView ? 'compact' : 'detailed'}
                onChange={(e) => setCompactView(e.target.value === 'compact')}
                label="View"
              >
                <MenuItem value="detailed">Detailed</MenuItem>
                <MenuItem value="compact">Compact</MenuItem>
              </Select>
            </FormControl>
            <Tooltip title="Export filtered courses">
              <IconButton 
                onClick={handleExportFiltered}
                disabled={!courses || courses.length === 0}
                sx={{ color: '#64748b' }}
              >
                <FileDownload />
              </IconButton>
            </Tooltip>
          </Box>
        </Box>
        
        <TextField
          fullWidth
          variant="outlined"
          placeholder="🔍 Search by course code, title, category, or equivalent courses..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)}
          sx={{ 
            mb: 4,
            '& .MuiOutlinedInput-root': {
              borderRadius: 3,
              background: 'linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%)',
              minHeight: '60px',
              fontSize: '1.1rem',
              '& fieldset': {
                borderColor: '#d1d5db',
                borderWidth: 2
              },
              '&:hover fieldset': {
                borderColor: '#b91c1c',
                borderWidth: 2
              },
              '&.Mui-focused fieldset': {
                borderColor: '#b91c1c',
                borderWidth: 2,
                boxShadow: '0 0 0 4px rgba(185, 28, 28, 0.1)'
              }
            },
            '& .MuiInputBase-input': {
              padding: '18px 16px',
              fontWeight: 500
            },
            '& .MuiInputBase-input::placeholder': {
              color: '#64748b',
              opacity: 1
            }
          }}
          InputProps={{
            startAdornment: (
              <InputAdornment position="start">
                <Search sx={{ color: '#b91c1c', fontSize: 28, mr: 1 }} />
              </InputAdornment>
            ),
            endAdornment: searchTerm && (
              <InputAdornment position="end">
                <IconButton 
                  onClick={() => setSearchTerm('')} 
                  size="large"
                  sx={{ 
                    color: '#64748b',
                    backgroundColor: '#fef2f2',
                    '&:hover': {
                      backgroundColor: '#b91c1c',
                      color: 'white'
                    },
                    transition: 'all 0.2s ease'
                  }}
                >
                  <Clear />
                </IconButton>
              </InputAdornment>
            )
          }}
        />

        <Grid container spacing={4} sx={{ mb: 3, justifyContent: 'center' }}>
          {/* Category Filter */}
          <Grid item xs={12} sm={8} md={6} lg={4}>
            <Box sx={{ position: 'relative' }}>
              <Typography variant="subtitle1" sx={{ 
                fontWeight: 'bold', 
                mb: 2, 
                color: '#374151',
                textAlign: 'center'
              }}>
                📂 Course Category
              </Typography>
              <FormControl fullWidth size="large">
                <InputLabel sx={{ fontSize: '1.1rem', fontWeight: 500, color: '#64748b' }}>
                  Select Category
                </InputLabel>
                <Select
                  value={filters.category}
                  onChange={(e) => updateFilter('category', e.target.value)}
                  label="Select Category"
                  sx={{ 
                    minHeight: '70px',
                    fontSize: '1.1rem',
                    borderRadius: 2,
                    backgroundColor: '#f8fafc'
                  }}
                >
                  <MenuItem value="">
                    <Box>
                      <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                        🔍 All Categories
                      </Typography>
                      <Typography variant="caption" sx={{ opacity: 0.7 }}>
                        📚 Show courses from all categories
                      </Typography>
                    </Box>
                  </MenuItem>
                  {Object.entries(CATEGORY_NAMES).map(([key, name]) => (
                    <MenuItem key={key} value={key}>
                      <Box>
                        <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                          📋 {name}
                        </Typography>
                        <Typography variant="caption" sx={{ opacity: 0.7 }}>
                          🎓 {key} category courses
                        </Typography>
                      </Box>
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Box>
          </Grid>
          
          {/* Semester Filter */}
          <Grid item xs={12} sm={8} md={6} lg={4}>
            <Box sx={{ position: 'relative' }}>
              <Typography variant="subtitle1" sx={{ 
                fontWeight: 'bold', 
                mb: 2, 
                color: '#374151',
                textAlign: 'center'
              }}>
                📅 Academic Semester
              </Typography>
              <FormControl fullWidth size="large">
                <InputLabel sx={{ fontSize: '1.1rem', fontWeight: 500, color: '#64748b' }}>
                  Select Semester
                </InputLabel>
                <Select
                  value={filters.semester}
                  onChange={(e) => updateFilter('semester', e.target.value)}
                  label="Select Semester"
                  sx={{ 
                    minHeight: '70px',
                    fontSize: '1.1rem',
                    borderRadius: 2,
                    backgroundColor: '#f8fafc'
                  }}
                >
                  <MenuItem value="">
                    <Box>
                      <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                        🔍 All Semesters
                      </Typography>
                      <Typography variant="caption" sx={{ opacity: 0.7 }}>
                        📚 Show courses from all semesters
                      </Typography>
                    </Box>
                  </MenuItem>
                  {getUniqueValues('semester').map(semester => (
                    <MenuItem key={semester} value={semester}>
                      <Box>
                        <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                          📚 {getSemesterDisplayName(semester)}
                        </Typography>
                        <Typography variant="caption" sx={{ opacity: 0.7 }}>
                          🗓️ Semester {semester} courses
                        </Typography>
                      </Box>
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Box>
          </Grid>

          {/* Credits Filter */}
          <Grid item xs={12} sm={8} md={6} lg={4}>
            <Box sx={{ position: 'relative' }}>
              <Typography variant="subtitle1" sx={{ 
                fontWeight: 'bold', 
                mb: 2, 
                color: '#374151',
                textAlign: 'center'
              }}>
                🎯 Course Credits
              </Typography>
              <FormControl fullWidth size="large">
                <InputLabel sx={{ fontSize: '1.1rem', fontWeight: 500, color: '#64748b' }}>
                  Select Credits
                </InputLabel>
                <Select
                  value={filters.credits}
                  onChange={(e) => updateFilter('credits', e.target.value)}
                  label="Select Credits"
                  sx={{ 
                    minHeight: '70px',
                    fontSize: '1.1rem',
                    borderRadius: 2,
                    backgroundColor: '#f8fafc'
                  }}
                >
                  <MenuItem value="">
                    <Box>
                      <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                        🔍 All Credits
                      </Typography>
                      <Typography variant="caption" sx={{ opacity: 0.7 }}>
                        📚 Show courses with any credit value
                      </Typography>
                    </Box>
                  </MenuItem>
                  {getUniqueValues('credits').map(credits => (
                    <MenuItem key={credits} value={credits.toString()}>
                      <Box>
                        <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                          💳 {credits} Credits
                        </Typography>
                        <Typography variant="caption" sx={{ opacity: 0.7 }}>
                          🎓 {credits} credit courses
                        </Typography>
                      </Box>
                    </MenuItem>
                  ))}
                </Select>
              </FormControl>
            </Box>
          </Grid>
        </Grid>

        <Box sx={{ display: 'flex', justifyContent: 'center', mb: 3 }}>
          <Button
            variant="outlined"
            startIcon={<Clear />}
            onClick={clearFilters}
            disabled={!hasActiveFilters}
            sx={{
              height: '50px',
              minWidth: '200px',
              borderRadius: 2,
              borderColor: '#d1d5db',
              color: '#374151',
              fontSize: '1rem',
              px: 3,
              '&:hover': {
                borderColor: '#b91c1c',
                backgroundColor: '#fef2f2',
                color: '#b91c1c'
              },
              '&:disabled': {
                borderColor: '#e5e7eb',
                color: '#9ca3af'
              }
            }}
          >
            Clear Filters
          </Button>
        </Box>

        {hasActiveFilters && (
          <Box sx={{ 
            display: 'flex', 
            gap: 1, 
            flexWrap: 'wrap', 
            alignItems: 'center',
            p: 2,
            backgroundColor: '#f8fafc',
            borderRadius: 1,
            border: '1px solid #e2e8f0'
          }}>
            <Typography variant="body2" sx={{ color: '#64748b', fontWeight: 500 }}>
              Active filters:
            </Typography>
            {searchTerm && (
              <Chip 
                label={`Search: "${searchTerm}"`} 
                onDelete={() => setSearchTerm('')}
                size="small"
                sx={{ backgroundColor: '#b91c1c', color: 'white' }}
              />
            )}
            {filters.category && (
              <Chip 
                label={`Category: ${getCategoryName(filters.category)}`} 
                onDelete={() => updateFilter('category', '')}
                size="small"
                sx={{ backgroundColor: '#b91c1c', color: 'white' }}
              />
            )}
            {filters.semester && (
              <Chip 
                label={`Semester: ${getSemesterDisplayName(filters.semester)}`} 
                onDelete={() => updateFilter('semester', '')}
                size="small"
                sx={{ backgroundColor: '#b91c1c', color: 'white' }}
              />
            )}
            {filters.credits && (
              <Chip 
                label={`Credits: ${filters.credits}`} 
                onDelete={() => updateFilter('credits', '')}
                size="small"
                sx={{ backgroundColor: '#b91c1c', color: 'white' }}
              />
            )}
          </Box>
        )}
      </CardContent>
    </Card>
  );
};

const EnhancedStatistics = ({ curriculumData, nonElectiveStats }) => {
  const [selectedChart, setSelectedChart] = useState('category');

  const categoryChartData = useMemo(() => {
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
          percentage: nonElectiveStats.totalCourses > 0 ? ((count / nonElectiveStats.totalCourses) * 100).toFixed(1) : '0',
          color: getCategoryColor(cat.category)
        };
      })
      .filter(cat => cat.value > 0);
  }, [curriculumData, nonElectiveStats]);

  const semesterChartData = useMemo(() => {
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
  }, [curriculumData]);

  const cumulativeData = useMemo(() => {
    if (!curriculumData?.statistics?.semester_breakdown) return [];
    
    return curriculumData.statistics.semester_breakdown
      .filter(sem => sem.semester !== 'Elective')
      .sort((a, b) => compareSemesters(a.semester, b.semester))
      .reduce((acc, sem, index) => {
        const prev = acc[index - 1] || { cumulativeCredits: 0, cumulativeEcts: 0 };
        acc.push({
          semester: getSemesterDisplayName(sem.semester),
          cumulativeCredits: prev.cumulativeCredits + sem.credits,
          cumulativeEcts: prev.cumulativeEcts + sem.ects
        });
        return acc;
      }, []);
  }, [curriculumData]);

  const chartOptions = [
    { value: 'category', label: 'Category Distribution', icon: PieChart },
    { value: 'semester', label: 'Semester Breakdown', icon: BarChart },
    { value: 'cumulative', label: 'Cumulative Progress', icon: Timeline }
  ];

  const renderChart = () => {
    switch (selectedChart) {
      case 'category':
        return (
          <ResponsiveContainer width="100%" height={400}>
            <RechartsPieChart>
              <Pie
                data={categoryChartData}
                cx="50%"
                cy="50%"
                labelLine={false}
                label={({ percent }) => percent > 0.05 ? `${(percent * 100).toFixed(0)}%` : null}
                outerRadius={120}
                fill="#940612"
                dataKey="value"
              >
                {categoryChartData.map((entry, index) => (
                  <Cell key={`cell-${index}`} fill={entry.color} />
                ))}
              </Pie>
              <RechartsTooltip 
                formatter={(value, name) => [value, name]}
                labelFormatter={(label) => `Category: ${label}`}
              />
              <Legend />
            </RechartsPieChart>
          </ResponsiveContainer>
        );
      
      case 'semester':
        return (
          <ResponsiveContainer width="100%" height={400}>
            <RechartsBarChart data={semesterChartData}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="semester" />
              <YAxis />
              <RechartsTooltip />
              <Bar dataKey="credits" fill="#8a0b18" name="Credits" />
              <Bar dataKey="ects" fill="#1d0e5c" name="ECTS" />
              <Legend />
            </RechartsBarChart>
          </ResponsiveContainer>
        );
      
      case 'cumulative':
        return (
          <ResponsiveContainer width="100%" height={400}>
            <LineChart data={cumulativeData}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="semester" />
              <YAxis />
              <RechartsTooltip />
              <Line 
                type="monotone" 
                dataKey="cumulativeCredits" 
                stroke="#8c0d0d" 
                strokeWidth={3}
                name="Cumulative Credits"
              />
              <Line 
                type="monotone" 
                dataKey="cumulativeEcts" 
                stroke="#0e24c9" 
                strokeWidth={3}
                name="Cumulative ECTS"
              />
              <Legend />
            </LineChart>
          </ResponsiveContainer>
        );
      
      default:
        return null;
    }
  };

  return (
    <Box>
      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
        <Typography variant="h6" gutterBottom sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
          <Analytics /> Curriculum Statistics & Analytics
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

      {/* Chart Selection */}
      <Box sx={{ mb: 3 }}>
        <Typography variant="subtitle1" sx={{ mb: 2, fontWeight: 'bold' }}>
          Select Chart View:
        </Typography>
        <Stack direction="row" spacing={3} flexWrap="wrap">
          {chartOptions.map(option => (
            <Button
              key={option.value}
              variant={selectedChart === option.value ? 'contained' : 'outlined'}
              startIcon={<option.icon />}
              onClick={() => setSelectedChart(option.value)}
              sx={{
                borderRadius: 2,
                textTransform: 'none',
                '&.MuiButton-contained': {
                  backgroundColor: '#b91c1c',
                  '&:hover': {
                    backgroundColor: '#991b1b'
                  }
                }
              }}
            >
              {option.label}
            </Button>
          ))}
        </Stack>
      </Box>

      {/* Chart Display */}
      <Card sx={{ mb: 4 }}>
        <CardContent>
          <Typography variant="h6" gutterBottom>
            {chartOptions.find(opt => opt.value === selectedChart)?.label}
          </Typography>
          {renderChart()}
        </CardContent>
      </Card>

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
              {categoryChartData.map((cat) => (
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
              {semesterChartData.map((sem) => (
                <Box key={sem.semester} sx={{ mb: 2 }}>
                  <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 1 }}>
                    <Typography variant="body1" sx={{ fontWeight: 'bold' }}>
                      {sem.semester}
                    </Typography>
                    <Chip 
                      label={`${sem.courses} courses`} 
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
                      width: `${(sem.courses / nonElectiveStats.totalCourses) * 100}%`,
                      height: '100%',
                      backgroundColor: '#1976d2',
                      borderRadius: 4
                    }} />
                  </Box>
                </Box>
              ))}
              
              {/* Elective Courses Information */}
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
    </Box>
  );
};

// =============================================================================
// MAIN COMPONENT
// =============================================================================

function CurriculumPage() {
  const { 
    departments, 
    curriculumData, 
    fetchDepartments, 
    fetchCurriculumData, 
    clearCache,
    loading, 
    error,
    setError
  } = useCurriculumData();
  
  const { 
    searchTerm, 
    setSearchTerm, 
    debouncedSearchTerm,
    filters, 
    updateFilter, 
    filteredCourses, 
    hasActiveFilters, 
    clearFilters 
  } = useSearchAndFilter(curriculumData?.all_courses);
  
  const [selectedDepartment, setSelectedDepartment] = useState('');
  const [selectedVersion, setSelectedVersion] = useState('');
  const [tabValue, setTabValue] = useState(0);
  const [compactView, setCompactView] = useState(false);
  const [snackbar, setSnackbar] = useState({ open: false, message: '', severity: 'info' });

  // Computed values
  const nonElectiveStats = useMemo(() => {
    if (!curriculumData?.all_courses) return { totalCourses: 0, totalCredits: 0, totalEcts: 0 };
    
    const nonElectiveCourses = curriculumData.all_courses.filter(course => 
      course.semester && 
      course.semester !== 'Elective' && 
      course.semester.toString().toLowerCase() !== 'elective'
    );
    
    return {
      totalCourses: nonElectiveCourses.length,
      totalCredits: nonElectiveCourses.reduce((sum, course) => sum + course.credits, 0),
      totalEcts: nonElectiveCourses.reduce((sum, course) => sum + course.ects, 0)
    };
  }, [curriculumData?.all_courses]);

  const statisticsData = useMemo(() => {
    if (!curriculumData) return {};
    
    return {
      version: curriculumData.version,
      courses: nonElectiveStats.totalCourses,
      credits: nonElectiveStats.totalCredits,
      ects: nonElectiveStats.totalEcts,
      average: nonElectiveStats.totalCourses > 0 
        ? (nonElectiveStats.totalCredits / nonElectiveStats.totalCourses).toFixed(2)
        : 0
    };
  }, [curriculumData, nonElectiveStats]);

  // Event handlers
  const handleDepartmentChange = useCallback((event) => {
    const departmentId = event.target.value;
    setSelectedDepartment(departmentId);
    setSelectedVersion('');
  }, []);

  const handleVersionChange = useCallback((event) => {
    const version = event.target.value;
    setSelectedVersion(version);
    
    if (selectedDepartment && version) {
      fetchCurriculumData(selectedDepartment, version);
    }
  }, [selectedDepartment, fetchCurriculumData]);

  const handleExportAll = useCallback(() => {
    if (!curriculumData) return;
    
    const data = {
      department: curriculumData.department.name,
      version: curriculumData.version,
      courses: curriculumData.all_courses,
      statistics: nonElectiveStats,
      exportDate: new Date().toISOString()
    };
    
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `curriculum-${curriculumData.department.name}-${curriculumData.version}.json`;
    a.click();
    URL.revokeObjectURL(url);
    
    setSnackbar({ open: true, message: 'Curriculum data exported successfully', severity: 'success' });
  }, [curriculumData, nonElectiveStats]);

  const handleRefresh = useCallback(() => {
    clearCache();
    fetchDepartments();
    if (selectedDepartment && selectedVersion) {
      fetchCurriculumData(selectedDepartment, selectedVersion);
    }
    setSnackbar({ open: true, message: 'Data refreshed successfully', severity: 'success' });
  }, [clearCache, fetchDepartments, fetchCurriculumData, selectedDepartment, selectedVersion]);

  // Effects
  useEffect(() => {
    fetchDepartments();
  }, [fetchDepartments]);

  // Sorting functions
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

  const getSortedSemesters = useCallback((semesters) => {
    return [...semesters].sort((a, b) => compareSemesters(a.semester, b.semester));
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
  }, []);

  const getFilteredSemesters = useCallback((semesters) => {
    return semesters.map(semester => ({
      ...semester,
      courses: semester.courses.filter(course => 
        filteredCourses.some(filtered => filtered.course_id === course.course_id)
      )
    })).filter(semester => semester.courses.length > 0);
  }, [filteredCourses]);

  const getFilteredCategories = useCallback((categories) => {
    return categories.map(category => ({
      ...category,
      courses: category.courses.filter(course => 
        filteredCourses.some(filtered => filtered.course_id === course.course_id)
      )
    })).filter(category => category.courses.length > 0);
  }, [filteredCourses]);

  return (
    <Box sx={{ p: 3, width: '100%', minHeight: '100vh' }}>
      {/* Header */}
      <Box sx={{ mb: 6 }}>
        <Box sx={{ 
          textAlign: 'center', 
          mb: 4,
          background: 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%)',
          color: '#1e293b',
          py: 6,
          px: 4,
          borderRadius: 3,
          boxShadow: '0 4px 20px rgba(0,0,0,0.08)',
          border: '1px solid #e2e8f0'
        }}>
          <School sx={{ fontSize: 60, mb: 2, color: '#b91c1c' }} />
          <Typography variant="h3" component="h1" gutterBottom sx={{ 
            fontWeight: 'bold',
            color: '#1e293b',
            mb: 2
          }}>
            Curriculum Management
          </Typography>
          <Typography variant="h6" sx={{ color: '#64748b', maxWidth: 600, mx: 'auto' }}>
            Comprehensive curriculum analysis and course management system
          </Typography>
        </Box>
        
        {curriculumData && (
          <Box sx={{ 
            mt: 3, 
            p: 3, 
            backgroundColor: '#b91c1c',
            borderRadius: 2,
            color: 'white',
            textAlign: 'center',
            boxShadow: '0 4px 20px rgba(185, 28, 28, 0.2)',
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center'
          }}>
            <Typography variant="h6" sx={{ fontWeight: 'bold' }}>
              📚 Currently Viewing: {curriculumData.department.name} - {curriculumData.version} Curriculum
            </Typography>
            <Box sx={{ display: 'flex', gap: 2 }}>
              <Tooltip title="Export All Data">
                <IconButton onClick={handleExportAll} sx={{ color: 'white' }}>
                  <Download />
                </IconButton>
              </Tooltip>
              <Tooltip title="Refresh Data">
                <IconButton onClick={handleRefresh} sx={{ color: 'white' }}>
                  <Refresh />
                </IconButton>
              </Tooltip>
            </Box>
          </Box>
        )}
      </Box>

      {/* Department and Version Selection */}
      <Card sx={{ 
        mb: 6, 
        borderRadius: 3,
        boxShadow: '0 4px 20px rgba(0,0,0,0.08)',
        backgroundColor: '#ffffff',
        border: '1px solid #e2e8f0'
      }}>
        <CardContent sx={{ p: 5 }}>
          <Box sx={{ textAlign: 'center', mb: 5 }}>
            <Typography variant="h4" gutterBottom sx={{ 
              fontWeight: 'bold',
              color: '#1e293b',
              mb: 2
            }}>
              🎓 Select Your Program
            </Typography>
            <Typography variant="body1" color="#64748b" sx={{ maxWidth: 500, mx: 'auto' }}>
              Choose your department and curriculum version to explore course requirements and academic pathways
            </Typography>
          </Box>

          <Grid container spacing={6} justifyContent="center" sx={{ mb: 4 }}>
            <Grid item xs={12} sm={10} md={8} lg={6}>
              <Box sx={{ position: 'relative' }}>
                <Typography variant="subtitle1" sx={{ 
                  fontWeight: 'bold', 
                  mb: 2, 
                  color: '#374151',
                  textAlign: 'center'
                }}>
                  🏛️ Academic Department
                </Typography>
                <FormControl fullWidth size="large">
                  <InputLabel sx={{ fontSize: '1.1rem', fontWeight: 500, color: '#64748b' }}>
                    Select Department
                  </InputLabel>
                  <Select
                    value={selectedDepartment}
                    onChange={handleDepartmentChange}
                    label="Select Department"
                    disabled={loading}
                    sx={{ 
                      minHeight: '70px',
                      fontSize: '1.1rem',
                      borderRadius: 2,
                      backgroundColor: '#f8fafc'
                    }}
                  >
                    {departments.map((dept) => (
                      <MenuItem key={dept.id} value={dept.id}>
                        <Box>
                          <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                            🎓 {dept.name}
                          </Typography>
                          <Typography variant="caption" sx={{ opacity: 0.7 }}>
                            📚 {dept.available_versions?.length || 0} curriculum version(s) available
                          </Typography>
                        </Box>
                      </MenuItem>
                    ))}
                  </Select>
                </FormControl>
              </Box>
            </Grid>
            
            <Grid item xs={12} sm={10} md={8} lg={6}>
              <Box sx={{ position: 'relative' }}>
                <Typography variant="subtitle1" sx={{ 
                  fontWeight: 'bold', 
                  mb: 2, 
                  color: '#374151',
                  textAlign: 'center'
                }}>
                  📅 Curriculum Version
                </Typography>
                <FormControl 
                  fullWidth 
                  size="large"
                  disabled={!selectedDepartment || loading}
                >
                  <InputLabel sx={{ fontSize: '1.1rem', fontWeight: 500, color: '#64748b' }}>
                    Select Version
                  </InputLabel>
                  <Select
                    value={selectedVersion}
                    onChange={handleVersionChange}
                    label="Select Version"
                    sx={{ 
                      minHeight: '70px',
                      fontSize: '1.1rem',
                      borderRadius: 2,
                      backgroundColor: selectedDepartment ? '#f8fafc' : '#f1f5f9'
                    }}
                  >
                    {selectedDepartment && 
                      departments
                        .find(dept => dept.id === selectedDepartment)
                        ?.available_versions.map((version) => (
                          <MenuItem key={version} value={version}>
                            <Box>
                              <Typography variant="body1" sx={{ fontWeight: 'bold', mb: 0.5 }}>
                                📖 {version} Curriculum
                              </Typography>
                              <Typography variant="caption" sx={{ opacity: 0.7 }}>
                                🗓️ Academic Year {version}
                              </Typography>
                            </Box>
                          </MenuItem>
                        ))
                    }
                  </Select>
                </FormControl>
              </Box>
            </Grid>
          </Grid>
          
          <Box sx={{ 
            display: 'flex', 
            justifyContent: 'center',
            alignItems: 'center',
            mt: 4,
            p: 3,
            backgroundColor: '#f8fafc',
            borderRadius: 2,
            border: '1px solid #e2e8f0'
          }}>
            <Button
              startIcon={<Refresh />}
              onClick={handleRefresh}
              disabled={loading}
              variant="contained"
              size="large"
              sx={{ 
                minHeight: '56px',
                fontSize: '1rem',
                px: 4,
                borderRadius: 2,
                backgroundColor: '#b91c1c',
                boxShadow: '0 4px 15px rgba(185, 28, 28, 0.2)',
                '&:hover': {
                  backgroundColor: '#991b1b',
                  boxShadow: '0 6px 20px rgba(185, 28, 28, 0.3)',
                  transform: 'translateY(-1px)'
                },
                '&:disabled': {
                  backgroundColor: '#9ca3af',
                  boxShadow: 'none'
                },
                transition: 'all 0.2s ease'
              }}
            >
              🔄 Refresh Data
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
            <Button color="inherit" size="small" onClick={handleRefresh}>
              Retry
            </Button>
          }
        >
          {error}
        </Alert>
      )}

      {/* Main Content */}
      {curriculumData && (
        <Box>
          {/* Search and Filter */}
          <EnhancedSearchAndFilter 
            searchTerm={searchTerm}
            setSearchTerm={setSearchTerm}
            filters={filters}
            updateFilter={updateFilter}
            clearFilters={clearFilters}
            hasActiveFilters={hasActiveFilters}
            courses={filteredCourses}
            compactView={compactView}
            setCompactView={setCompactView}
          />

          {/* Statistics Cards */}
          <Grid container spacing={3} sx={{ mb: 4 }}>
            {STAT_CARD_CONFIGS.map((config, index) => (
              <Grid item xs={12} sm={6} md={2.4} key={config.key}>
                <StatCard
                  title={config.title}
                  value={statisticsData[config.key]}
                  subtitle={config.key === 'courses' ? 'Semester courses only' : 
                           config.key === 'credits' ? 'Semester credits only' :
                           config.key === 'ects' ? 'Semester ECTS only' :
                           config.key === 'average' ? 'Core courses average' : 'Current Version'}
                  icon={config.icon}
                  isLoading={loading}
                  color={config.color}
                  bgColor={config.bgColor}
                />
              </Grid>
            ))}
          </Grid>

          {/* Tabs for different views */}
          <Card>
            <Box sx={{ borderBottom: 1, borderColor: 'divider', backgroundColor: '#f8f9fa' }}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', px: 2, py: 1 }}>
                <Tabs value={tabValue} onChange={(e, newValue) => setTabValue(newValue)} aria-label="curriculum tabs">
                  <Tab 
                    label="By Semester" 
                    icon={<Timeline />}
                    iconPosition="start"
                    sx={{ textTransform: 'none' }}
                  />
                  <Tab 
                    label="By Category" 
                    icon={<Category />}
                    iconPosition="start"
                    sx={{ textTransform: 'none' }}
                  />
                  <Tab 
                    label="All Courses" 
                    icon={<MenuBook />}
                    iconPosition="start"
                    sx={{ textTransform: 'none' }}
                  />
                  <Tab 
                    label="Statistics" 
                    icon={<Analytics />}
                    iconPosition="start"
                    sx={{ textTransform: 'none' }}
                  />
                </Tabs>
                <Box sx={{ display: 'flex', gap: 1, alignItems: 'center' }}>
                  <Typography variant="body2" color="text.secondary" sx={{ fontWeight: 'bold' }}>
                    {hasActiveFilters ? 
                      `${filteredCourses.length} of ${curriculumData.all_courses.length} courses` :
                      `${curriculumData.all_courses.length} total courses`
                    }
                  </Typography>
                  <Chip 
                    label={`${curriculumData.version} Curriculum`} 
                    color="primary" 
                    variant="outlined"
                    size="small"
                    sx={{ fontWeight: 'bold' }}
                  />
                </Box>
              </Box>
            </Box>

            {/* By Semester Tab */}
            <TabPanel value={tabValue} index={0}>
              <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 3 }}>
                <Typography variant="h6" gutterBottom>
                  Courses by Semester
                </Typography>
                <Box sx={{ display: 'flex', gap: 1, alignItems: 'center' }}>
                  {hasActiveFilters && (
                    <Typography variant="body2" color="text.secondary">
                      {filteredCourses.length} of {curriculumData.all_courses.length} courses
                    </Typography>
                  )}
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
                      <CourseTable courses={getSortedCourses(semester.courses)} compactView={compactView} />
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
                {hasActiveFilters && (
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
                      <CourseTable courses={category.courses} showSemester={true} compactView={compactView} />
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
                {hasActiveFilters && (
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
                <CourseTable courses={getSortedAllCourses(filteredCourses)} showSemester={true} compactView={compactView} />
              )}
            </TabPanel>

            {/* Statistics Tab */}
            <TabPanel value={tabValue} index={3}>
              <EnhancedStatistics curriculumData={curriculumData} nonElectiveStats={nonElectiveStats} />
            </TabPanel>
          </Card>
        </Box>
      )}

      {/* Snackbar for notifications */}
      <Snackbar
        open={snackbar.open}
        autoHideDuration={6000}
        onClose={() => setSnackbar(prev => ({ ...prev, open: false }))}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
      >
        <Alert 
          onClose={() => setSnackbar(prev => ({ ...prev, open: false }))} 
          severity={snackbar.severity}
          sx={{ width: '100%' }}
        >
          {snackbar.message}
        </Alert>
      </Snackbar>
    </Box>
  );
}

export default CurriculumPage;