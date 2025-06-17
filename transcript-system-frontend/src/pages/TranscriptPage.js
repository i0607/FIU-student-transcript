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
} from "@mui/material";
import PictureAsPdfIcon from "@mui/icons-material/PictureAsPdf";
import DownloadIcon from "@mui/icons-material/Download";

function TranscriptPage() {
  const [studentId, setStudentId] = useState("");
  const [data, setData] = useState(null);
  const [error, setError] = useState("");

  const fetchTranscript = async () => {
    try {
      const token = localStorage.getItem("token");
      const res = await axios.get(`http://127.0.0.1:8000/api/transcripts/${studentId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      });
      setData(res.data);
      setError("");
    } catch (err) {
      setError("Student not found or unauthorized");
      setData(null);
    }
  };

  // Helper function to get grade points for display only
  const getGradePoint = (grade) => {
    const gradePoints = {
      'A': 4.00, 'A-': 3.70, 'B+': 3.30, 'B': 3.00, 'B-': 2.70,
      'C+': 2.30, 'C': 2.00, 'C-': 1.70, 'D+': 1.30, 'D': 1.00,
      'D-': 0.70, 'F': 0.00, 'FF': 0.00
    };
    return gradePoints[grade?.toUpperCase()] ?? (
      ['NG', 'W', 'S', 'I', 'U', 'P', 'E', 'TS', 'T1', 'CS', 'H', 'PS', 'TU', 'TR', 'T', 'P0', 'TP', 'TF'].includes(grade?.toUpperCase()) 
        ? null : 0.00
    );
  };

  return (
    <Container maxWidth="lg" sx={{ mt: 5, mb: 10 }}>
      <Typography variant="h4" gutterBottom>Transcript Viewer</Typography>

      <Stack direction="row" spacing={2} mb={4}>
        <TextField
          label="Student Number"
          variant="outlined"
          value={studentId}
          onChange={(e) => setStudentId(e.target.value)}
          fullWidth
        />
        <Button variant="contained" onClick={fetchTranscript}>Search</Button>
      </Stack>

      {error && <Typography color="error">{error}</Typography>}

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
              <Typography variant="h6">Student Information</Typography>
              <Divider sx={{ my: 1 }} />
              <Grid container spacing={2}>
                <Grid item xs={6}>
                  <Typography><strong>Name:</strong> {data.student.name}</Typography>
                  <Typography><strong>Student Number:</strong> {data.student.studentNumber}</Typography>
                  <Typography><strong>Department:</strong> {data.student.departmentId}</Typography>
                </Grid>
                <Grid item xs={6}>
                  <Typography><strong>Date of Birth:</strong> {data.student.date_of_birth}</Typography>
                  <Typography><strong>Entry Date:</strong> {data.student.entry_date}</Typography>
                  <Typography><strong>Graduation Date:</strong> {data.student.graduation_date}</Typography>
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
                    Credits Earned
                  </Typography>
                </Box>
              </Grid>
              <Grid item xs={12} md={3}>
                <Box textAlign="center">
                  <Typography variant="h4" color="info.main" fontWeight="bold">
                    {data.total_credits_attempted || 0}
                  </Typography>
                  <Typography variant="subtitle2" color="text.secondary">
                    Credits Attempted
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
          {data.transcript.map((semester, i) => {
            return (
              <Card key={i} sx={{ mb: 4 }}>
                <CardContent>
                  <Typography variant="h6" color="primary" gutterBottom>
                    📚 Semester: {semester.semester}
                  </Typography>
                  <Table size="small">
                    <TableHead>
                      <TableRow sx={{ backgroundColor: "#f0f0f0" }}>
                        <TableCell><b>Code</b></TableCell>
                        <TableCell><b>Title</b></TableCell>
                        <TableCell><b>Grade</b></TableCell>
                        <TableCell><b>Credits</b></TableCell>
                        <TableCell><b>Grade Points</b></TableCell>
                        <TableCell><b>Category</b></TableCell>
                      </TableRow>
                    </TableHead>
                    <TableBody>
                      {semester.courses.map((course, j) => {
                        const gradePoint = getGradePoint(course.grade);
                        const courseGradePoints = gradePoint !== null ? 
                          ((course.credits || 0) * gradePoint).toFixed(2) : 
                          (course.counts_in_gpa === false ? "N/A" : "0.00");
                        
                        return (
                          <TableRow key={j}>
                            <TableCell>{course.code}</TableCell>
                            <TableCell>{course.title}</TableCell>
                            <TableCell>
                              <Chip
                                label={course.grade || "N/A"}
                                color={
                                  ["F", "FF"].includes(course.grade)
                                    ? "error"
                                    : gradePoint === null
                                    ? "default"
                                    : course.grade
                                    ? "success"
                                    : "warning"
                                }
                                size="small"
                              />
                            </TableCell>
                            <TableCell>{course.credits}</TableCell>
                            <TableCell>
                              <strong>{courseGradePoints}</strong>
                            </TableCell>
                            <TableCell>
                              <Chip
                                label={course.category}
                                size="small"
                                sx={{
                                  backgroundColor: course.color,
                                  color: "#fff",
                                  fontWeight: "bold",
                                }}
                              />
                            </TableCell>
                          </TableRow>
                        );
                      })}
                      
                      {/* SEMESTER TOTALS ROW - Using Backend Data */}
                      <TableRow sx={{ backgroundColor: "#e3f2fd", fontWeight: "bold" }}>
                        <TableCell colSpan={2}>
                          <Typography variant="subtitle2" fontWeight="bold">
                            📊 SEMESTER TOTALS
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Chip label="TOTAL" color="primary" size="small" />
                        </TableCell>
                        <TableCell>
                          <Typography fontWeight="bold" color="primary">
                            {semester.semester_credits || 0} / {semester.semester_ects || semester.courses.reduce((sum, c) => sum + (c.ects_credits || c.credits || 0), 0)}
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Typography fontWeight="bold" color="primary">
                            {semester.semester_grade_points || "0,00"}
                          </Typography>
                        </TableCell>
                        <TableCell>
                          <Chip 
                            label={`GPA: ${semester.semester_gpa || "0.00"}`} 
                            color="primary" 
                            size="small" 
                          />
                        </TableCell>
                      </TableRow>
                    </TableBody>
                  </Table>

                  {/* Semester Summary - Using Backend Data */}
                  <Paper elevation={2} sx={{ mt: 2, p: 2, backgroundColor: "#f8f9fa" }}>
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

          {/* Remaining Courses */}
          <Card sx={{ mb: 4 }}>
            <CardContent>
              <Typography variant="h6" color="warning.main">📋 Remaining Courses</Typography>
              <Divider sx={{ my: 1 }} />
              {data.remaining_courses.length === 0 ? (
                <Typography color="success.main" variant="h6" align="center">
                  🎉 All required courses completed!
                </Typography>
              ) : (
                <>
                  <Typography variant="body2" color="text.secondary" mb={2}>
                    {data.remaining_courses.length} course(s) remaining • {data.remaining_courses.reduce((sum, course) => sum + (course.credits || 0), 0)} credits needed
                  </Typography>
                  <Table size="small">
                    <TableHead>
                      <TableRow sx={{ backgroundColor: "#fff3cd" }}>
                        <TableCell><b>Code</b></TableCell>
                        <TableCell><b>Title</b></TableCell>
                        <TableCell><b>Credits</b></TableCell>
                        <TableCell><b>Category</b></TableCell>
                        <TableCell><b>Semester</b></TableCell>
                      </TableRow>
                    </TableHead>
                    <TableBody>
                      {data.remaining_courses.map((course, index) => (
                        <TableRow key={index}>
                          <TableCell>{course.code}</TableCell>
                          <TableCell>{course.title}</TableCell>
                          <TableCell>{course.credits}</TableCell>
                          <TableCell>
                            <Chip label={course.category} size="small" color="warning" />
                          </TableCell>
                          <TableCell>{course.semester}</TableCell>
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
                  <strong>Completion:</strong> {data.total_credits > 0 ? Math.round((data.total_credits / (data.total_credits + data.remaining_courses.reduce((sum, course) => sum + (course.credits || 0), 0))) * 100) : 0}%
                </Typography>
              </Grid>
              <Grid item xs={12} md={4} textAlign="center">
                <Typography variant="body1">
                  <strong>Credits to Graduate:</strong> {data.remaining_courses.reduce((sum, course) => sum + (course.credits || 0), 0)}
                </Typography>
              </Grid>
            </Grid>
          </Paper>
        </>
      )}
    </Container>
  );
}

export default TranscriptPage;