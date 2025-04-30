// src/pages/AdminPage.js
import { useEffect, useState } from "react";
import axios from "axios";
import StaffTable from "../components/StaffTable";
import StaffForm from "../components/StaffForm";
import { Snackbar, Alert } from "@mui/material";

import {
  Box,
  Typography,
  Button,
  Stack,
  Container,
  Paper,
  Dialog,
  DialogTitle,
  DialogContent
} from "@mui/material";
import AddIcon from '@mui/icons-material/Add';

function AdminPage() {
  const [staffList, setStaffList] = useState([]);
  const [selectedStaff, setSelectedStaff] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const token = localStorage.getItem("token");
  const [snackbar, setSnackbar] = useState({ open: false, message: "", severity: "success" });

  const fetchStaff = async () => {
    try {
      const res = await axios.get("http://127.0.0.1:8000/api/staff", {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        },
      });
      setStaffList(res.data);
    } catch (err) {
      console.error("Failed to fetch staff", err);
    }
  };

  useEffect(() => {
    fetchStaff();
  }, []);

  const handleAdd = () => {
    setSelectedStaff(null);
    setShowForm(true);
  };

  const handleEdit = (staff) => {
    setSelectedStaff(staff);
    setShowForm(true);
  };

  const handleDelete = async (id) => {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/staff/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      fetchStaff();
      setSnackbar({ open: true, message: "Staff deleted successfully!", severity: "success" });
    } catch (err) {
      console.error("Failed to delete staff", err);
      setSnackbar({ open: true, message: "Failed to delete staff!", severity: "error" });
    }
  };

  const handleFormSubmit = () => {
    setShowForm(false);
    fetchStaff();
  };

  return (
    <Container maxWidth="lg">
      <Box mt={8}>
        <Stack direction="row" justifyContent="space-between" alignItems="center" mb={4}>
          <Typography variant="h4" fontWeight="bold">
            Staff Management
          </Typography>
          <Button variant="contained" startIcon={<AddIcon />} onClick={handleAdd}>
            Add Staff
          </Button>
        </Stack>

        <Paper elevation={3} sx={{ p: 3 }}>
          <StaffTable staff={staffList} onEdit={handleEdit} onDelete={handleDelete} />
        </Paper>

        <Dialog open={showForm} onClose={() => setShowForm(false)} maxWidth="sm" fullWidth>
          <DialogTitle>{selectedStaff ? "Edit Staff" : "Add Staff"}</DialogTitle>
          <DialogContent>
            <StaffForm
              staff={selectedStaff}
              onClose={() => setShowForm(false)}
              onSubmit={handleFormSubmit}
            />
          </DialogContent>
        </Dialog>
      </Box>
      <Snackbar
        open={snackbar.open}
        autoHideDuration={3000}
        onClose={() => setSnackbar({ ...snackbar, open: false })}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}
      >
        <Alert
          onClose={() => setSnackbar({ ...snackbar, open: false })}
          severity={snackbar.severity}
          sx={{ width: '100%' }}
        >
          {snackbar.message}
        </Alert>
      </Snackbar>

    </Container>
    
  );
  
}

export default AdminPage;
