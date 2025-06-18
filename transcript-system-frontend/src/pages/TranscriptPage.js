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
} from "@mui/material";
import PictureAsPdfIcon from "@mui/icons-material/PictureAsPdf";
import DownloadIcon from "@mui/icons-material/Download";

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
                </Grid>
              </Grid>
            </CardContent>
          </Card>

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
                Curriculum: {data.student?.studentNumber?.startsWith('19') || data.student?.studentNumber?.startsWith('20') ? 'Old (19/20)' : 'New (21+)'} |
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
                              color={course.version === 'old' ? 'secondary' : 'primary'}
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
              <Grid item xs={12} md={4} textAlign="center">
                <Typography variant="body1">
                  <strong>Status:</strong> {data.cumulative_gpa >= 2.0 ? "Good Standing" : "Academic Warning"}
                </Typography>
              </Grid>
              <Grid item xs={12} md={4} textAlign="center">
                <Typography variant="body1">
                  <strong>Courses Completed:</strong> {data.transcript?.reduce((total, sem) => total + sem.courses.length, 0) || 0}
                </Typography>
              </Grid>
              <Grid item xs={12} md={4} textAlign="center">
                <Typography variant="body1">
                  <strong>Credits to Graduate:</strong> {data.remaining_courses?.reduce((sum, course) => sum + (course.credits || 0), 0) || 0}
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