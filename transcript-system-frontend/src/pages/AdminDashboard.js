import { useState, useEffect } from "react";
import { Box, Typography, Grid, Paper, Table, TableHead, TableRow, TableCell, TableBody } from "@mui/material";
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
    return <Typography variant="h6" sx={{ p: 4 }}>Loading dashboard...</Typography>;
  }

  return (
    <Box sx={{ padding: 4 }}>
      <Typography variant="h4" gutterBottom>Admin Dashboard</Typography>

      {/* Stat Cards */}
      <Grid container spacing={3}>
        {[
          { label: "Total Staff", value: stats.staffCount, color: "primary" },
          { label: "Total Students", value: stats.studentCount, color: "secondary" },
          { label: "Total Courses", value: stats.courseCount, color: "success.main" },
          { label: "Transcripts Issued", value: stats.transcriptCount, color: "error.main" },
        ].map((item, index) => (
          <Grid item xs={12} sm={6} md={3} key={index}>
            <Paper sx={{ padding: 3, textAlign: "center" }}>
              <Typography variant="h6">{item.label}</Typography>
              <Typography variant="h4" sx={{ color: item.color }}>{item.value}</Typography>
            </Paper>
          </Grid>
        ))}
      </Grid>

      {/* Bar Chart */}
      <Box sx={{ mt: 6 }}>
        <Typography variant="h5" gutterBottom>Overview</Typography>
        <Paper sx={{ padding: 4 }}>
          <BarChart
            xAxis={[{ scaleType: 'band', data: ['Staff', 'Students', 'Courses', 'Transcripts'] }]}
            series={[
              { data: [stats.staffCount, stats.studentCount, stats.courseCount, stats.transcriptCount] },
            ]}
            width={600}
            height={300}
          />
        </Paper>
      </Box>

      {/* Recent Staff */}
      <Box sx={{ mt: 6 }}>
        <Typography variant="h5" gutterBottom>Recent Staff Registrations</Typography>
        <Paper sx={{ padding: 2, overflowX: 'auto' }}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>Email</TableCell>
                <TableCell>Created At</TableCell>
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
        <Typography variant="h5" gutterBottom>Recent Transcripts Issued</Typography>
        <Paper sx={{ padding: 2, overflowX: 'auto' }}>
          <Table>
            <TableHead>
              <TableRow>
                <TableCell>Transcript ID</TableCell>
                <TableCell>Student Name</TableCell>
                <TableCell>Issued At</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {recentData.recentTranscripts.map((transcript) => (
                <TableRow key={transcript.id}>
                  <TableCell>{transcript.id}</TableCell>
                  <TableCell>{transcript.student?.name ?? 'Unknown'}</TableCell>
                  <TableCell>{new Date(transcript.created_at).toLocaleString()}</TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </Paper>
      </Box>
    </Box>
  );
}

export default AdminDashboard;
