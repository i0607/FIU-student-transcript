import { useState } from "react";
import axios from "axios";
import {
  Container,
  Typography,
  TextField,
  Button,
  Card,
  CardContent,
  Table,
  TableHead,
  TableBody,
  TableRow,
  TableCell,
  Grid,
  Divider,
  Chip,
  Stack,
  Box,
  Paper,
  Alert,
  CircularProgress,
  LinearProgress,
  Accordion,
  AccordionSummary,
  AccordionDetails,
  List,
  ListItem,
  ListItemText,
  Badge,
} from "@mui/material";
import PictureAsPdfIcon from "@mui/icons-material/PictureAsPdf";
import DownloadIcon from "@mui/icons-material/Download";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import CheckCircleIcon from "@mui/icons-material/CheckCircle";
import CancelIcon from "@mui/icons-material/Cancel";
import SchoolIcon from "@mui/icons-material/School";
import WarningIcon from "@mui/icons-material/Warning";

function TranscriptPage() {
  const [studentId, setStudentId] = useState("");
  const [data, setData] = useState(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const fetchTranscript = async () => {
    if (!studentId.trim()) {
      setError("Please enter a student number");
      return;
    }

    try {
      setLoading(true);
      setError("");
      
      // Fixed API endpoint - matches your backend
      const res = await axios.get(`http://127.0.0.1:8000/api/transcripts/${studentId}`, {
        headers: {
          Accept: "application/json",
        },
      });
      
      setData(res.data);
    } catch (err) {
      console.error("API Error:", err.response?.data || err.message);
      setError(err.response?.data?.message || "Student not found or network error");
      setData(null);
    } finally {
      setLoading(false);
    }
  };

  const handleKeyPress = (event) => {
    if (event.key === 'Enter') {
      fetchTranscript();
    }
  };

  // Helper function to get grade color
  const getGradeColor = (grade) => {
    if (grade === 'A' || grade === 'A-') return 'success';
    if (grade === 'B+' || grade === 'B' || grade === 'B-') return 'info';
    if (grade === 'C+' || grade === 'C' || grade === 'C-') return 'warning';
    if (grade === 'D+' || grade === 'D' || grade === 'D-') return 'secondary';
    if (grade === 'F' || grade === 'FF') return 'error';
    if (grade === 'NG' || grade === 'E') return 'default';
    return 'default';
  };

  // Helper function to get verification status color
  const getVerificationColor = (isVerified) => {
    return isVerified ? 'success' : 'error';
  };

  // Helper function to get progress color
  const getProgressColor = (percentage) => {
    if (percentage >= 100) return 'success';
    if (percentage >= 75) return 'info';
    if (percentage >= 50) return 'warning';
    return 'error';
  };

  // Sort transcripts to put exempted courses first
  const sortedTranscript = data?.transcript ? data.transcript.sort((a, b) => {
    const aIsExempted = a.semester.toLowerCase().includes('exempted') || 
                        a.semester.toLowerCase().includes('exemption') ||
                        a.semester.toLowerCase().includes('preparatory');
    const bIsExempted = b.semester.toLowerCase().includes('exempted') || 
                        b.semester.toLowerCase().includes('exemption') ||
                        b.semester.toLowerCase().includes('preparatory');
    
    if (aIsExempted && !bIsExempted) return -1;
    if (!aIsExempted && bIsExempted) return 1;
    
    return a.semester.localeCompare(b.semester);
  }) : [];

  // Graduation Requirements Component
  const GraduationRequirementsCard = ({ graduationRequirements }) => {
    if (!graduationRequirements) return null;

    const { overall_verified, verification_summary, elective_requirements } = graduationRequirements;
    
    return (
      <Card sx={{ mb: 4, border: overall_verified ? '2px solid #4caf50' : '2px solid #f44336' }}>
        <CardContent>
          <Box display="flex" alignItems="center" mb={2}>
            {overall_verified ? (
              <CheckCircleIcon sx={{ color: 'success.main', mr: 1, fontSize: 28 }} />
            ) : (
              <CancelIcon sx={{ color: 'error.main', mr: 1, fontSize: 28 }} />
            )}
            <Typography variant="h5" color={overall_verified ? 'success.main' : 'error.main'}>
              🎓 Graduation Requirements Verification
            </Typography>
          </Box>

          {/* Overall Status */}
          <Paper 
            elevation={2} 
            sx={{ 
              p: 2, 
              mb: 3, 
              backgroundColor: overall_verified ? '#e8f5e8' : '#fdeaea',
              border: `1px solid ${overall_verified ? '#4caf50' : 'hsla(4, 90%, 58%, 1.00)'}`
            }}
          >
            <Typography variant="h6" align="center" gutterBottom>
              {verification_summary?.status || 'Status Unknown'}
            </Typography>
            <Typography variant="body1" align="center" color="text.secondary">
              {verification_summary?.message || 'No message available'}
            </Typography>
            
            <Box mt={2}>
              <Typography variant="body2" gutterBottom>
                Progress: {verification_summary?.verified_categories || 0}/{verification_summary?.total_categories || 3} Categories Verified
              </Typography>
              <LinearProgress
                variant="determinate"
                value={verification_summary?.verification_percentage || 0}
                color={getProgressColor(verification_summary?.verification_percentage || 0)}
                sx={{ height: 8, borderRadius: 4 }}
              />
              <Typography variant="caption" color="text.secondary">
                {verification_summary?.verification_percentage || 0}% Complete
              </Typography>
            </Box>
          </Paper>

          {/* Quick Summary Cards */}
          <Grid container spacing={2} mb={3}>
            {Object.entries(elective_requirements || {}).map(([category, requirement]) => {
              const totalCompleted = requirement.current_status?.total_courses_taken || 0;
              const validECTS = requirement.current_status?.valid_courses_count || 0;
              const required = requirement.requirement?.min_courses || 4;
              const minECTS = requirement.requirement?.min_ects_per_course || 0;
              const isVerified = requirement.verification?.is_verified;
              const hasECTSIssues = totalCompleted > validECTS;

              return (
                <Grid item xs={12} md={4} key={category}>
                  <Card 
                    elevation={2}
                    sx={{ 
                      border: isVerified ? '2px solid #4caf50' : hasECTSIssues ? '2px solid #ff9800' : '2px solid #f44336',
                      backgroundColor: isVerified ? '#f1f8e9' : hasECTSIssues ? '#fff3e0' : '#fdeaea'
                    }}
                  >
                    <CardContent sx={{ p: 2 }}>
                      <Box display="flex" alignItems="center" mb={1}>
                        {isVerified ? (
                          <CheckCircleIcon sx={{ color: 'success.main', mr: 1 }} />
                        ) : hasECTSIssues ? (
                          <WarningIcon sx={{ color: 'warning.main', mr: 1 }} />
                        ) : (
                          <CancelIcon sx={{ color: 'error.main', mr: 1 }} />
                        )}
                        <Typography variant="h6" fontSize="1rem">
                          {requirement.category_name} ({category})
                        </Typography>
                      </Box>
                      
                      {/* Course Count Progress */}
                      <Box mb={1}>
                        <Box display="flex" justifyContent="space-between" alignItems="center">
                          <Typography variant="body2" fontWeight="bold">
                            Courses: {totalCompleted}/{required}
                          </Typography>
                          <Typography variant="caption" color="text.secondary">
                            {Math.round((totalCompleted / required) * 100)}%
                          </Typography>
                        </Box>
                        <LinearProgress
                          variant="determinate"
                          value={Math.min((totalCompleted / required) * 100, 100)}
                          color={totalCompleted >= required ? 'success' : 'error'}
                          sx={{ height: 6, borderRadius: 3, mb: 0.5 }}
                        />
                      </Box>

                      {/* ECTS Compliance Progress */}
                      <Box mb={1}>
                        <Box display="flex" justifyContent="space-between" alignItems="center">
                          <Typography variant="body2" fontWeight="bold">
                            ECTS OK: {validECTS}/{totalCompleted || required}
                          </Typography>
                          <Typography variant="caption" color="text.secondary">
                            Min {minECTS} ECTS each
                          </Typography>
                        </Box>
                        <LinearProgress
                          variant="determinate"
                          value={totalCompleted > 0 ? (validECTS / Math.max(totalCompleted, required)) * 100 : 0}
                          color={validECTS >= required ? 'success' : hasECTSIssues ? 'warning' : 'error'}
                          sx={{ height: 6, borderRadius: 3 }}
                        />
                      </Box>

                      {/* Status Chip */}
                      <Box textAlign="center">
                        <Chip
                          label={
                            isVerified ? 'VERIFIED ✅' :
                            hasECTSIssues ? 'ECTS ISSUE ⚠️' :
                            'INCOMPLETE ❌'
                          }
                          color={
                            isVerified ? 'success' :
                            hasECTSIssues ? 'warning' :
                            'error'
                          }
                          size="small"
                          sx={{ fontWeight: 'bold' }}
                        />
                      </Box>

                      {/* Action Text */}
                      {!isVerified && (
                        <Typography variant="caption" color="text.secondary" display="block" textAlign="center" mt={1}>
                          {totalCompleted < required ? 
                            `Need ${required - totalCompleted} more courses` :
                            hasECTSIssues ?
                            `${totalCompleted - validECTS} courses need higher ECTS` :
                            'Check requirements'
                          }
                        </Typography>
                      )}
                    </CardContent>
                  </Card>
                </Grid>
              );
            })}
          </Grid>

          {/* Individual Category Requirements */}
          {Object.entries(elective_requirements || {}).map(([category, requirement]) => (
            <Accordion key={category} sx={{ mb: 1 }}>
              <AccordionSummary expandIcon={<ExpandMoreIcon />}>
                <Box display="flex" alignItems="center" width="100%">
                  {requirement.verification?.is_verified ? (
                    <CheckCircleIcon sx={{ color: 'success.main', mr: 2 }} />
                  ) : (
                    requirement.current_status?.total_courses_taken > requirement.current_status?.valid_courses_count ? (
                      <WarningIcon sx={{ color: 'warning.main', mr: 2 }} />
                    ) : (
                      <CancelIcon sx={{ color: 'error.main', mr: 2 }} />
                    )
                  )}
                  <Box flexGrow={1}>
                    <Typography variant="h6">
                      {requirement.category_name} ({category})
                    </Typography>
                    <Typography variant="body2" color="text.secondary">
                      {requirement.verification?.message || 'No status message'}
                    </Typography>
                  </Box>
                  <Box textAlign="right" mr={2}>
                    <Typography variant="body2" fontWeight="bold">
                      {requirement.current_status?.total_courses_taken || 0}/{requirement.requirement?.min_courses || 4} courses
                    </Typography>
                    <Typography variant="caption" color="text.secondary">
                      {requirement.current_status?.valid_courses_count || 0} meet ECTS req.
                    </Typography>
                  </Box>
                </Box>
              </AccordionSummary>
              <AccordionDetails>
                <Grid container spacing={3}>
                  {/* Requirement Details */}
                  <Grid item xs={12} md={4}>
                    <Typography variant="subtitle2" color="primary" gutterBottom>
                      📋 Requirements
                    </Typography>
                    <Typography variant="body2">
                      <strong>Minimum Courses:</strong> {requirement.requirement?.min_courses || 0}
                    </Typography>
                    <Typography variant="body2">
                      <strong>Min ECTS per Course:</strong> {requirement.requirement?.min_ects_per_course || 0}
                    </Typography>
                    <Typography variant="caption" color="text.secondary">
                      {requirement.requirement?.description || 'No description'}
                    </Typography>
                  </Grid>

                  {/* Current Status */}
                  <Grid item xs={12} md={4}>
                    <Typography variant="subtitle2" color="info.main" gutterBottom>
                      📊 Current Status
                    </Typography>
                    <Typography variant="body2">
                      <strong>Total Courses Taken:</strong> {requirement.current_status?.total_courses_taken || 0}
                    </Typography>
                    <Typography variant="body2">
                      <strong>ECTS Compliant:</strong> {requirement.current_status?.valid_courses_count || 0}
                    </Typography>
                    <Typography variant="body2">
                      <strong>Total ECTS:</strong> {requirement.current_status?.total_ects || 0}
                    </Typography>
                    <Typography variant="body2">
                      <strong>Courses Needed:</strong> {requirement.current_status?.missing_courses || 0}
                    </Typography>
                    {(requirement.current_status?.courses_needing_higher_ects || 0) > 0 && (
                      <Typography variant="body2" color="warning.main">
                        <strong>Need Higher ECTS:</strong> {requirement.current_status.courses_needing_higher_ects} courses
                      </Typography>
                    )}
                  </Grid>

                  {/* Verification Message */}
                  <Grid item xs={12} md={4}>
                    <Typography variant="subtitle2" color="secondary.main" gutterBottom>
                      ✅ Verification Status
                    </Typography>
                    <Alert 
                      severity={
                        requirement.verification?.is_verified ? 'success' : 
                        (requirement.current_status?.total_courses_taken > requirement.current_status?.valid_courses_count) ? 'warning' : 
                        'error'
                      }
                      sx={{ mb: 1 }}
                    >
                      {requirement.verification?.message || 'No verification message'}
                    </Alert>
                    
                    {/* Progress Details */}
                    <Typography variant="caption" color="text.secondary" display="block">
                      Course Progress: {requirement.verification?.progress || '0/0'}
                    </Typography>
                    <Typography variant="caption" color="text.secondary" display="block">
                      ECTS Compliance: {requirement.verification?.ects_compliance || '0/0'}
                    </Typography>
                  </Grid>
                </Grid>

                {/* All Completed Courses (including those with insufficient ECTS) */}
                {(requirement.completed_courses?.length > 0 || requirement.insufficient_ects_courses?.length > 0) && (
                  <Box mt={3}>
                    <Typography variant="subtitle2" color="primary.main" gutterBottom>
                      📚 All Completed Courses ({(requirement.completed_courses?.length || 0) + (requirement.insufficient_ects_courses?.length || 0)})
                    </Typography>
                    <Table size="small">
                      <TableHead>
                        <TableRow sx={{ backgroundColor: '#e3f2fd' }}>
                          <TableCell><b>Code</b></TableCell>
                          <TableCell><b>Title</b></TableCell>
                          <TableCell><b>ECTS</b></TableCell>
                          <TableCell><b>Grade</b></TableCell>
                          <TableCell><b>Semester</b></TableCell>
                          <TableCell><b>ECTS Status</b></TableCell>
                        </TableRow>
                      </TableHead>
                      <TableBody>
                        {/* Valid ECTS Courses */}
                        {(requirement.valid_ects_courses || requirement.completed_courses?.filter(c => 
                          c.ects_credits >= (requirement.requirement?.min_ects_per_course || 0)
                        ) || []).map((course, index) => (
                          <TableRow key={`valid-${index}`}>
                            <TableCell>{course.code}</TableCell>
                            <TableCell>{course.title}</TableCell>
                            <TableCell>
                              <Chip 
                                label={course.ects_credits} 
                                size="small" 
                                color="success"
                              />
                            </TableCell>
                            <TableCell>
                              <Chip
                                label={course.grade}
                                color={getGradeColor(course.grade)}
                                size="small"
                              />
                            </TableCell>
                            <TableCell>{course.semester}</TableCell>
                            <TableCell>
                              <Chip 
                                label="✅ OK" 
                                size="small" 
                                color="success"
                                variant="outlined"
                              />
                            </TableCell>
                          </TableRow>
                        ))}
                        
                        {/* Insufficient ECTS Courses */}
                        {(requirement.insufficient_ects_courses || []).map((course, index) => (
                          <TableRow key={`insufficient-${index}`} sx={{ backgroundColor: '#fff3e0' }}>
                            <TableCell>{course.code}</TableCell>
                            <TableCell>{course.title}</TableCell>
                            <TableCell>
                              <Chip 
                                label={course.ects_credits} 
                                size="small" 
                                color="warning"
                              />
                            </TableCell>
                            <TableCell>
                              <Chip
                                label={course.grade}
                                color={getGradeColor(course.grade)}
                                size="small"
                              />
                            </TableCell>
                            <TableCell>{course.semester}</TableCell>
                            <TableCell>
                              <Chip 
                                label={`⚠️ Need ${requirement.requirement?.min_ects_per_course || 0}`}
                                size="small" 
                                color="warning"
                                variant="outlined"
                              />
                            </TableCell>
                          </TableRow>
                        ))}
                      </TableBody>
                    </Table>
                  </Box>
                )}

                {/* Available Courses */}
                {requirement.available_courses?.length > 0 && (
                  <Box mt={3}>
                    <Typography variant="subtitle2" color="primary.main" gutterBottom>
                      🔍 Available Courses to Take ({requirement.available_courses.length})
                    </Typography>
                    <Typography variant="caption" color="text.secondary" display="block" mb={1}>
                      These courses meet the minimum ECTS requirement and haven't been taken yet.
                    </Typography>
                    <Table size="small">
                      <TableHead>
                        <TableRow sx={{ backgroundColor: '#e8f5e8' }}>
                          <TableCell><b>Code</b></TableCell>
                          <TableCell><b>Title</b></TableCell>
                          <TableCell><b>ECTS</b></TableCell>
                          <TableCell><b>Credits</b></TableCell>
                          <TableCell><b>Semester</b></TableCell>
                        </TableRow>
                      </TableHead>
                      <TableBody>
                        {requirement.available_courses.slice(0, 8).map((course, index) => (
                          <TableRow key={index}>
                            <TableCell>{course.code}</TableCell>
                            <TableCell>{course.title}</TableCell>
                            <TableCell>
                              <Chip 
                                label={course.ects_credits} 
                                size="small" 
                                color="primary"
                              />
                            </TableCell>
                            <TableCell>{course.credits}</TableCell>
                            <TableCell>{course.semester}</TableCell>
                          </TableRow>
                        ))}
                        {requirement.available_courses.length > 8 && (
                          <TableRow>
                            <TableCell colSpan={5} align="center">
                              <Typography variant="caption" color="text.secondary">
                                ... and {requirement.available_courses.length - 8} more courses
                              </Typography>
                            </TableCell>
                          </TableRow>
                        )}
                      </TableBody>
                    </Table>
                  </Box>
                )}
              </AccordionDetails>
            </Accordion>
          ))}
        </CardContent>
      </Card>
    );
  };

  return (
    <Container maxWidth="lg" sx={{ mt: 5, mb: 10 }}>
      <Typography variant="h4" gutterBottom>📋 Transcript Viewer</Typography>

      <Stack direction="row" spacing={2} mb={4}>
        <TextField
          label="Student Number"
          variant="outlined"
          value={studentId}
          onChange={(e) => setStudentId(e.target.value)}
          onKeyPress={handleKeyPress}
          placeholder="e.g., 2103010232"
          fullWidth
        />
        <Button 
          variant="contained" 
          onClick={fetchTranscript}
          disabled={loading}
          sx={{ minWidth: 120 }}
        >
          {loading ? <CircularProgress size={24} /> : 'Search'}
        </Button>
      </Stack>

      {error && (
        <Alert severity="error" sx={{ mb: 3 }}>
          {error}
        </Alert>
      )}

      {data && (
        <>
          {/* Export Buttons */}
          <Stack direction="row" spacing={2} mb={3}>
            <Button
              variant="outlined"
              color="primary"
              startIcon={<PictureAsPdfIcon />}
              href={`http://127.0.0.1:8000/api/transcripts/${studentId}/export/pdf`}
              target="_blank"
            >
              Export as PDF
            </Button>
            <Button
              variant="outlined"
              color="success"
              startIcon={<DownloadIcon />}
              href={`http://127.0.0.1:8000/api/transcripts/${studentId}/export/excel`}
              target="_blank"
            >
              Export as Excel
            </Button>
          </Stack>

          {/* Student Info */}
          <Card sx={{ mb: 4 }}>
            <CardContent>
              <Typography variant="h6">👤 Student Information</Typography>
              <Divider sx={{ my: 1 }} />
              <Grid container spacing={2}>
                <Grid item xs={6}>
                  <Typography><strong>Name:</strong> {data.student?.name || 'N/A'}</Typography>
                  <Typography><strong>Student Number:</strong> {data.student?.studentNumber || data.student?.student_number || 'N/A'}</Typography>
                  <Typography><strong>Department:</strong> {data.student?.departmentId || data.student?.department || 'N/A'}</Typography>
                </Grid>
                <Grid item xs={6}>
                  <Typography><strong>Date of Birth:</strong> {data.student?.date_of_birth || 'N/A'}</Typography>
                  <Typography><strong>Entry Date:</strong> {data.student?.entry_date || 'N/A'}</Typography>
                  <Typography><strong>Graduation Date:</strong> {data.student?.graduation_date || 'N/A'}</Typography>
                  <Typography><strong>Curriculum Version:</strong> {data.student?.curriculumVersion || 'N/A'}</Typography>
                </Grid>
              </Grid>
            </CardContent>
          </Card>

          {/* Graduation Requirements Verification */}
          <GraduationRequirementsCard graduationRequirements={data.graduation_requirements} />

          {/* GRAND TOTALS SUMMARY */}
          <Paper 
            elevation={4} 
            sx={{ 
              mb: 4, 
              p: 3, 
              backgroundColor: '#f8f9fa',
              border: '2px solid #007bff'
            }}
          >
            <Typography variant="h5" color="primary" gutterBottom align="center">
              🎓 GRAND TOTALS
            </Typography>
            <Divider sx={{ mb: 2 }} />
            <Grid container spacing={3}>
              <Grid item xs={12} md={3}>
                <Box textAlign="center">
                  <Typography variant="h4" color="success.main" fontWeight="bold">
                    {data.total_credits || 0}
                  </Typography>
                  <Typography variant="subtitle2" color="text.secondary">
                    Total Credits
                  </Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box textAlign="center">
                  <Typography variant="h4" color="info.main" fontWeight="bold">
                    {data.total_ects || 0}
                  </Typography>
                  <Typography variant="subtitle2" color="text.secondary">
                    Total ECTS
                  </Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box textAlign="center">
                  <Typography variant="h4" color="primary.main" fontWeight="bold">
                    {data.cumulative_gpa || "0.00"}
                  </Typography>
                  <Typography variant="subtitle2" color="text.secondary">
                    Cumulative GPA
                  </Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box textAlign="center">
                  <Typography variant="h4" color="warning.main" fontWeight="bold">
                    {data.total_grade_points || "0.00"}
                  </Typography>
                  <Typography variant="subtitle2" color="text.secondary">
                    Grade Points
                  </Typography>
                </Box>
              </Grid>
            </Grid>
          </Paper>

          {/* Transcript Semesters */}
          {sortedTranscript.map((semester, i) => {
            const isExemptedSemester = semester.semester.toLowerCase().includes('exempted') || 
                                     semester.semester.toLowerCase().includes('exemption') ||
                                     semester.semester.toLowerCase().includes('preparatory');
            
            return (
              <Card key={i} sx={{ 
                mb: 4,
                border: isExemptedSemester ? '2px solid orange' : '1px solid #e0e0e0'
              }}>
                <CardContent>
                  <Typography variant="h6" color={isExemptedSemester ? 'orange' : 'primary'} gutterBottom>
                    {isExemptedSemester ? '📋' : '📚'} Semester: {semester.semester}
                  </Typography>
                  <Table size="small">
                    <TableHead>
                      <TableRow sx={{ backgroundColor: isExemptedSemester ? "orange.50" : "#f0f0f0" }}>
                        <TableCell><b>Code</b></TableCell>
                        <TableCell><b>Title</b></TableCell>
                        <TableCell><b>Grade</b></TableCell>
                        <TableCell><b>Credits</b></TableCell>
                        <TableCell><b>ECTS</b></TableCell>
                        <TableCell><b>Grade Points</b></TableCell>
                        <TableCell><b>Category</b></TableCell>
                      </TableRow>
                    </TableHead>
                    <TableBody>
                      {semester.courses.map((course, j) => {
                        return (
                          <TableRow key={j}>
                            <TableCell>{course.code}</TableCell>
                            <TableCell>{course.title}</TableCell>
                            <TableCell>
                              <Chip
                                label={course.grade || "N/A"}
                                color={getGradeColor(course.grade)}
                                size="small"
                              />
                            </TableCell>
                            <TableCell>{course.credits}</TableCell>
                            <TableCell>{course.ects_credits}</TableCell>
                            <TableCell>
                              <strong>{course.grade_points}</strong>
                            </TableCell>
                            <TableCell>
                              <Chip
                                label={course.category || 'Others'}
                                size="small"
                                sx={{
                                  backgroundColor: course.color || '#9e9e9e',
                                  color: "#fff",
                                  fontWeight: "bold",
                                }}
                              />
                            </TableCell>
                          </TableRow>
                        );
                      })}
                      
                      {/* SEMESTER TOTALS ROW */}
                      <TableRow sx={{ backgroundColor: isExemptedSemester ? "orange.100" : "#e3f2fd", fontWeight: "bold" }}>
                        <TableCell colSpan={2}>
                          <Typography variant="subtitle2" fontWeight="bold">
                            📊 SEMESTER TOTALS
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Chip label="TOTAL" color={isExemptedSemester ? "default" : "primary"} size="small" />
                        </TableCell>
                        <TableCell>
                          <Typography fontWeight="bold" color={isExemptedSemester ? "orange" : "primary"}>
                            {semester.semester_credits || 0}
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Typography fontWeight="bold" color={isExemptedSemester ? "orange" : "primary"}>
                            {semester.semester_ects || 0}
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Typography fontWeight="bold" color={isExemptedSemester ? "orange" : "primary"}>
                            {semester.semester_grade_points || "0.00"}
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Chip 
                            label={`GPA: ${semester.semester_gpa || "0.00"}`} 
                            color={isExemptedSemester ? "default" : "primary"} 
                            size="small" 
                          />
                        </TableCell>
                      </TableRow>
                    </TableBody>
                  </Table>

                  {/* Semester Summary */}
                  <Paper elevation={2} sx={{ 
                    mt: 2, 
                    p: 2, 
                    backgroundColor: isExemptedSemester ? "orange.50" : "#f8f9fa" 
                  }}>
                    <Grid container spacing={2}>
                      <Grid item xs={12} md={3}>
                        <Typography variant="body2">
                          <strong>Semester GPA:</strong> {semester.semester_gpa || "0.00"}
                        </Typography>
                      </Grid>
                      <Grid item xs={12} md={3}>
                        <Typography variant="body2">
                          <strong>Cumulative GPA:</strong> {semester.cumulative_gpa || "0.00"}
                        </Typography>
                      </Grid>
                      <Grid item xs={12} md={3}>
                        <Typography variant="body2">
                          <strong>Credits Earned:</strong> {semester.semester_credits_earned || 0}
                        </Typography>
                      </Grid>
                      <Grid item xs={12} md={3}>
                        <Typography variant="body2">
                          <strong>Credits Attempted:</strong> {semester.semester_credits || 0}
                        </Typography>
                      </Grid>
                    </Grid>
                  </Paper>
                </CardContent>
              </Card>
            );
          })}

          {/* Remaining Courses - Always show this section */}
          <Card sx={{ mb: 4 }}>
            <CardContent>
              <Typography variant="h6" color="warning.main">📋 Remaining Courses</Typography>
              <Divider sx={{ my: 1 }} />
              
              {/* Debug Info */}
              <Typography variant="caption" color="text.secondary" sx={{ display: 'block', mb: 1 }}>
                Student Dept: {data.student?.departmentId} | 
                Curriculum: {data.student?.curriculumVersion || 'N/A'} |
                Remaining: {data.remaining_courses?.length || 0} | 
                Completed: {data.transcript?.reduce((total, sem) => total + sem.courses.length, 0) || 0}
              </Typography>
              
              {!data.remaining_courses || data.remaining_courses.length === 0 ? (
                <Alert severity="info" sx={{ mb: 2 }}>
                  <Typography variant="body2">
                    {data.remaining_courses === undefined 
                      ? "⚠️ Remaining courses data not loaded from backend"
                      : data.remaining_courses.length === 0 
                        ? "🎉 All required courses completed! (or no curriculum data available)"
                        : "No remaining course information available"}
                  </Typography>
                  <Typography variant="caption" color="text.secondary">
                    Check if courses table has curriculum data for department: {data.student?.departmentId}
                  </Typography>
                </Alert>
              ) : (
                <>
                  <Typography variant="body2" color="text.secondary" mb={2}>
                    {data.remaining_courses.length} course(s) remaining • {data.remaining_courses.reduce((sum, course) => sum + (course.credits || 0), 0)} credits needed
                    <br />
                    <span style={{ color: '#d32f2f' }}>
                      🔄 {data.remaining_courses.filter(c => c.is_retake).length} retakes required
                    </span>
                    {' • '}
                    <span style={{ color: '#ed6c02' }}>
                      📝 {data.remaining_courses.filter(c => !c.is_retake).length} not taken
                    </span>
                  </Typography>
                  <Table size="small">
                    <TableHead>
                      <TableRow sx={{ backgroundColor: "#fff3cd" }}>
                        <TableCell><b>Code</b></TableCell>
                        <TableCell><b>Title</b></TableCell>
                        <TableCell><b>Credits</b></TableCell>
                        <TableCell><b>ECTS</b></TableCell>
                        <TableCell><b>Category</b></TableCell>
                        <TableCell><b>Semester</b></TableCell>
                        <TableCell><b>Status</b></TableCell>
                        <TableCell><b>Version</b></TableCell>
                      </TableRow>
                    </TableHead>
                    <TableBody>
                      {data.remaining_courses.map((course, index) => (
                        <TableRow key={index}>
                          <TableCell>{course.code}</TableCell>
                          <TableCell>{course.title}</TableCell>
                          <TableCell>{course.credits}</TableCell>
                          <TableCell>{course.ects_credits}</TableCell>
                          <TableCell>
                            <Chip label={course.category || 'N/A'} size="small" color="warning" />
                          </TableCell>
                          <TableCell>{course.semester || 'N/A'}</TableCell>
                          <TableCell>
                            <Chip 
                              label={course.status || 'Not Taken'} 
                              size="small" 
                              color={course.is_retake ? 'error' : 'warning'}
                              variant={course.is_retake ? 'filled' : 'outlined'}
                            />
                          </TableCell>
                          <TableCell>
                            <Chip 
                              label={course.version || 'N/A'} 
                              size="small" 
                              color={course.version === 'Old' ? 'secondary' : 'primary'}
                            />
                          </TableCell>
                        </TableRow>
                      ))}
                    </TableBody>
                  </Table>
                </>
              )}
            </CardContent>
          </Card>

          {/* Final Academic Standing */}
          <Paper 
            elevation={3} 
            sx={{ 
              p: 3, 
              backgroundColor: data.cumulative_gpa >= 2.0 ? '#d4edda' : '#f8d7da',
              border: `2px solid ${data.cumulative_gpa >= 2.0 ? '#28a745' : '#dc3545'}`
            }}
          >
            <Typography variant="h6" align="center" gutterBottom>
              📈 Academic Standing
            </Typography>
            <Grid container spacing={2} justifyContent="center">
              <Grid item xs={12} md={3} textAlign="center">
                <Typography variant="body1">
                  <strong>Status:</strong> {data.cumulative_gpa >= 2.0 ? "Good Standing" : "Academic Warning"}
                </Typography>
              </Grid>
              <Grid item xs={12} md={3} textAlign="center">
                <Typography variant="body1">
                  <strong>Courses Completed:</strong> {data.transcript?.reduce((total, sem) => total + sem.courses.length, 0) || 0}
                </Typography>
              </Grid>
              <Grid item xs={12} md={3} textAlign="center">
                <Typography variant="body1">
                  <strong>Credits to Graduate:</strong> {data.remaining_courses?.reduce((sum, course) => sum + (course.credits || 0), 0) || 0}
                </Typography>
              </Grid>
              <Grid item xs={12} md={3} textAlign="center">
                <Typography variant="body1">
                  <strong>Electives Status:</strong> 
                  {data.graduation_requirements?.overall_verified ? (
                    <Chip label="✅ VERIFIED" color="success" size="small" sx={{ ml: 1 }} />
                  ) : (
                    <Chip label="❌ NOT VERIFIED" color="error" size="small" sx={{ ml: 1 }} />
                  )}
                </Typography>
              </Grid>
            </Grid>
          </Paper>
        </>
      )}

      {/* No Data Message */}
      {!loading && !data && !error && (
        <Card sx={{ textAlign: 'center', py: 6 }}>
          <CardContent>
            <Typography variant="h6" color="text.secondary" gutterBottom>
              No Transcript Data
            </Typography>
            <Typography variant="body2" color="text.secondary">
              Enter a student number above to view their academic transcript.
            </Typography>
          </CardContent>
        </Card>
      )}
    </Container>
  );
}

export default TranscriptPage;