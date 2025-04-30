import { useEffect, useState } from "react";
import axios from "axios";
import {
  Box,
  Typography,
  Button,
  Stack,
  TextField,
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  IconButton
} from "@mui/material";
import DeleteIcon from '@mui/icons-material/Delete';

function DepartmentPage() {
  const [departments, setDepartments] = useState([]);
  const [newDepartment, setNewDepartment] = useState("");

  const token = localStorage.getItem("token");

  const fetchDepartments = async () => {
    try {
      const res = await axios.get('http://127.0.0.1:8000/api/departments');
      setDepartments(res.data);
    } catch (err) {
      console.error("Failed to fetch departments", err);
    }
  };

  useEffect(() => {
    fetchDepartments();
  }, []);

  const handleAddDepartment = async () => {
    if (!newDepartment.trim()) return;

    try {
      await axios.post('http://127.0.0.1:8000/api/departments', { name: newDepartment }, {
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/json",
        }
      });
      setNewDepartment("");
      fetchDepartments();
    } catch (err) {
      console.error("Failed to add department", err);
    }
  };

  const handleDeleteDepartment = async (id) => {
    if (!window.confirm("Are you sure you want to delete this department?")) return;

    try {
      await axios.delete(`http://127.0.0.1:8000/api/departments/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      });
      fetchDepartments();
    } catch (err) {
      console.error("Failed to delete department", err);
    }
  };

  return (
    <Box maxWidth="md" mx="auto" mt={6}>
      <Typography variant="h4" fontWeight="bold" mb={4}>Manage Departments</Typography>

      <Stack direction="row" spacing={2} mb={4}>
        <TextField
          label="New Department"
          value={newDepartment}
          onChange={(e) => setNewDepartment(e.target.value)}
          fullWidth
        />
        <Button variant="contained" onClick={handleAddDepartment}>
          Add
        </Button>
      </Stack>

      <TableContainer component={Paper}>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell><b>ID</b></TableCell>
              <TableCell><b>Department Name</b></TableCell>
              <TableCell align="center"><b>Actions</b></TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {departments.map((dept) => (
              <TableRow key={dept.id} hover>
                <TableCell>{dept.id}</TableCell>
                <TableCell>{dept.name}</TableCell>
                <TableCell align="center">
                  <IconButton color="error" onClick={() => handleDeleteDepartment(dept.id)}>
                    <DeleteIcon />
                  </IconButton>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>
    </Box>
  );
}

export default DepartmentPage;
