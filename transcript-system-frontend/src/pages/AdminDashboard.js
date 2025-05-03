import { useState, useEffect } from "react";
import {
  Box, Typography, Grid, Paper, Table, TableHead,
  TableRow, TableCell, TableBody, Divider
} from "@mui/material";
import { BarChart } from "@mui/x-charts";
import axios from "axios";

function AdminDashboard() {
  const [stats, setStats] = useState(null);
  const [recentData, setRecentData] = useState(null);
  const token = localStorage.getItem("token");

  useEffect(() => {
    const fetchDashboardData = async () => {
      try {
        const statsResponse = await axios.get("http://127.0.0.1:8000/api/admin/dashboard-stats", {
          headers: { Authorization: `Bearer ${token}`, Accept: "application/json" },
        });
        const recentResponse = await axios.get("http://127.0.0.1:8000/api/admin/recent-data", {
          headers: { Authorization: `Bearer ${token}`, Accept: "application/json" },
        });

        setStats(statsResponse.data);
        setRecentData(recentResponse.data);
      } catch (error) {
        console.error("Failed to fetch dashboard data:", error);
      }
    };

    fetchDashboardData();
  }, [token]);

  if (!stats || !recentData) {
    return (
      <Box
        sx={{
          minHeight: "100vh",
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          background: "url('/background-pattern.png')", // Add the triangle pattern image to public/
          backgroundSize: "cover",
        }}
      >
        <Typography variant="h6">Loading dashboard...</Typography>
      </Box>
    );
  }

  return (
    <Box
      sx={{
        minHeight: "100vh",
        backgroundSize: "cover",
        padding: 4,
      }}
    >
      <Box
        sx={{
          maxWidth: "1200px",
          margin: "auto",
          backgroundColor: "white",
          borderRadius: 3,
          boxShadow: 6,
          padding: 4,
        }}
      >
        <Typography variant="h4" fontWeight="bold" gutterBottom align="center">
          Admin Dashboard
        </Typography>

        <Divider sx={{ mb: 4 }} />

        {/* Stat Cards */}
        <Grid container spacing={3}>
          {[
            { label: "Total Staff", value: stats.staffCount, color: "#007bff" },
            { label: "Total Students", value: stats.studentCount, color: "#6c757d" },
            { label: "Total Courses", value: stats.courseCount, color: "#28a745" },
            { label: "Transcripts Issued", value: stats.transcriptCount, color: "#dc3545" },
          ].map((item, index) => (
            <Grid item xs={12} sm={6} md={3} key={index}>
              <Paper
                sx={{
                  p: 3,
                  textAlign: "center",
                  borderRadius: 2,
                  boxShadow: 3,
                }}
              >
                <Typography variant="subtitle1">{item.label}</Typography>
                <Typography variant="h4" sx={{ color: item.color }}>
                  {item.value}
                </Typography>
              </Paper>
            </Grid>
          ))}
        </Grid>

        {/* Bar Chart */}
        <Box sx={{ mt: 6 }}>
          <Typography variant="h5" gutterBottom>
            System Overview
          </Typography>
          <Paper sx={{ p: 4, borderRadius: 2, boxShadow: 3 }}>
            <BarChart
              xAxis={[{ scaleType: "band", data: ["Staff", "Students", "Courses", "Transcripts"] }]}
              series={[{ data: [stats.staffCount, stats.studentCount, stats.courseCount, stats.transcriptCount] }]}
              width={600}
              height={300}
            />
          </Paper>
        </Box>

        {/* Recent Staff */}
        <Box sx={{ mt: 6 }}>
          <Typography variant="h5" gutterBottom>
            Recent Staff Registrations
          </Typography>
          <Paper sx={{ padding: 2, borderRadius: 2, boxShadow: 3 }}>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell><strong>Email</strong></TableCell>
                  <TableCell><strong>Created At</strong></TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {recentData.recentStaff.map((staff) => (
                  <TableRow key={staff.id}>
                    <TableCell>{staff.email}</TableCell>
                    <TableCell>{new Date(staff.created_at).toLocaleString()}</TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </Paper>
        </Box>

        {/* Recent Transcripts */}
        <Box sx={{ mt: 6 }}>
          <Typography variant="h5" gutterBottom>
            Recent Transcripts Issued
          </Typography>
          <Paper sx={{ padding: 2, borderRadius: 2, boxShadow: 3 }}>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell><strong>Transcript ID</strong></TableCell>
                  <TableCell><strong>Student Name</strong></TableCell>
                  <TableCell><strong>Issued At</strong></TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {recentData.recentTranscripts.map((transcript) => (
                  <TableRow key={transcript.id}>
                    <TableCell>{transcript.id}</TableCell>
                    <TableCell>{transcript.student?.name ?? "Unknown"}</TableCell>
                    <TableCell>{new Date(transcript.created_at).toLocaleString()}</TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </Paper>
        </Box>
      </Box>
    </Box>
  );
}

export default AdminDashboard;
