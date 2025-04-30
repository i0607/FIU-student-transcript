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
      const res = await axios.get(
        `http://127.0.0.1:8000/api/transcripts/${studentId}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        }
      );
      setData(res.data);
      setError("");
    } catch (err) {
      setError("Student not found or unauthorized");
      setData(null);
    }
  };

  return (
    <Container maxWidth="lg" sx={{ mt: 5, mb: 10 }}>
      <Typography variant="h4" gutterBottom>
        Transcript Viewer
      </Typography>

      <Stack direction="row" spacing={2} mb={4}>
        <TextField
          label="Student Number"
          variant="outlined"
          value={studentId}
          onChange={(e) => setStudentId(e.target.value)}
          fullWidth
        />
        <Button variant="contained" onClick={fetchTranscript}>
          Search
        </Button>
      </Stack>

      {error && <Typography color="error">{error}</Typography>}

      {data && (
        <>
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

          {/* Transcript Semesters */}
          {data.transcript.map((semester, i) => (
            <Card key={i} sx={{ mb: 4 }}>
              <CardContent>
                <Typography variant="h6" color="primary" gutterBottom>
                  Semester: {semester.semester}
                </Typography>
                <Table size="small">
                  <TableHead>
                    <TableRow sx={{ backgroundColor: "#f0f0f0" }}>
                      <TableCell><b>Code</b></TableCell>
                      <TableCell><b>Title</b></TableCell>
                      <TableCell><b>Grade</b></TableCell>
                      <TableCell><b>Credits</b></TableCell>
                      <TableCell><b>Category</b></TableCell>
                    </TableRow>
                  </TableHead>
                  <TableBody>
                    {semester.courses.map((course, j) => {
                      let gradeColor = "default";
                      if (["F", "FF"].includes(course.grade)) gradeColor = "error";
                      else if (!course.grade) gradeColor = "warning";
                      else gradeColor = "success";

                      return (
                        <TableRow key={j}>
                          <TableCell>{course.code}</TableCell>
                          <TableCell>{course.title}</TableCell>
                          <TableCell>
                            <Chip label={course.grade || "N/A"} color={gradeColor} size="small" />
                          </TableCell>
                          <TableCell>{course.credits}</TableCell>
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
                  </TableBody>
                </Table>

                <Stack direction="row" spacing={3} mt={2}>
                  <Typography variant="body2"><strong>GPA:</strong> {semester.gpa}</Typography>
                  <Typography variant="body2"><strong>Cumulative GPA:</strong> {semester.cumulative_gpa}</Typography>
                </Stack>
              </CardContent>
            </Card>
          ))}

          {/* Final Summary */}
          <Card sx={{ mb: 3 }}>
            <CardContent>
              <Typography variant="h6">Summary</Typography>
              <Divider sx={{ my: 1 }} />
              <Typography>Total Credits: {data.total_credits}</Typography>
              <Typography>Total ECTS: {data.total_ects}</Typography>
            </CardContent>
          </Card>

          {/* Export Buttons */}
          <Stack direction="row" spacing={2}>
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
        </>
      )}
    </Container>
  );
}

export default TranscriptPage;
