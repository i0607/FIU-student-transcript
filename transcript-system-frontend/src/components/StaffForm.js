import { useState, useEffect } from "react";
import axios from "axios";
import {
  DialogActions,
  Button,
  TextField,
  Select,
  MenuItem,
  FormControl,
  InputLabel,
  Stack,
  Snackbar,
  Alert,
  FormHelperText,
  CircularProgress,
} from "@mui/material";

function StaffForm({ staff, onClose, onSubmit }) {
  const [form, setForm] = useState({
    name: staff?.name || "",
    surname: staff?.surname || "",
    staffNumber: staff?.staffNumber || "",
    department: staff?.department || "",
    email: staff?.email || "",
    password: "",
    role: staff?.role || "staff",
  });

  const [snackbar, setSnackbar] = useState({ open: false, message: "", severity: "success" });
  const [passwordError, setPasswordError] = useState("");
  const [departmentList, setDepartmentList] = useState([]);
  const [loadingDepartments, setLoadingDepartments] = useState(true);

  const token = localStorage.getItem("token");

  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/departments')
      .then(res => {
        setDepartmentList(res.data);
        setLoadingDepartments(false);
      })
      .catch(err => {
        console.error('Failed to fetch departments', err);
        setLoadingDepartments(false);
      });
  }, []);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });

    if (e.target.name === "password") {
      const value = e.target.value;
      if (value.length < 8 || !/\d/.test(value) || !/[a-zA-Z]/.test(value)) {
        setPasswordError("Password must be at least 8 characters, and include letters and numbers.");
      } else {
        setPasswordError("");
      }
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
  
    if (!token) {
      console.error("❌ No token found in localStorage!");
      return;
    }
  
    if (passwordError) {
      console.error("❌ Password doesn't meet security criteria.");
      return;
    }
  
    try {
      if (staff) {
        await axios.put(`http://127.0.0.1:8000/api/staff/${staff.id}`, form, {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        });
        setSnackbar({ open: true, message: "Staff updated successfully!", severity: "success" });
      } else {
        await axios.post(`http://127.0.0.1:8000/api/staff`, form, {
          headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
          },
        });
        setSnackbar({ open: true, message: "Staff added successfully!", severity: "success" });
      }
  
      setTimeout(() => {
        onSubmit();
      }, 1000);
    } catch (err) {
      console.error("❌ Failed to save staff", err);
      setSnackbar({ 
        open: true, 
        message: "Failed to save staff", 
        severity: "error" 
      });
    }
  };
  

  const handleCloseSnackbar = () => {
    setSnackbar({ ...snackbar, open: false });
  };

  return (
    <>
      <form onSubmit={handleSubmit}>
        <Stack spacing={3} mt={2}>
          <TextField
            label="First Name"
            name="name"
            value={form.name}
            onChange={handleChange}
            fullWidth
            required
          />

          <TextField
            label="Surname"
            name="surname"
            value={form.surname}
            onChange={handleChange}
            fullWidth
            required
          />

          <TextField
            label="Staff Number"
            name="staffNumber"
            value={form.staffNumber}
            onChange={handleChange}
            fullWidth
            required
          />

          <FormControl fullWidth required>
            <InputLabel id="department-label">Department</InputLabel>
            <Select
              labelId="department-label"
              name="department"
              value={form.department}
              onChange={handleChange}
              label="Department"
            >
              {loadingDepartments ? (
                <MenuItem value="">
                  <CircularProgress size={20} /> Loading...
                </MenuItem>
              ) : (
                departmentList.map((dept) => (
                  <MenuItem key={dept.id} value={dept.name}>
                    {dept.name}
                  </MenuItem>
                ))
              )}
            </Select>
          </FormControl>

          <TextField
            label="Email"
            type="email"
            name="email"
            value={form.email}
            onChange={handleChange}
            fullWidth
            required
          />

          <FormControl fullWidth>
            <TextField
              label="Password"
              type="password"
              name="password"
              value={form.password}
              onChange={handleChange}
              error={!!passwordError}
            />
            {passwordError && (
              <FormHelperText error>{passwordError}</FormHelperText>
            )}
          </FormControl>

          <FormControl fullWidth>
            <InputLabel id="role-label">Role</InputLabel>
            <Select
              labelId="role-label"
              name="role"
              value={form.role}
              onChange={handleChange}
              label="Role"
            >
              <MenuItem value="admin">Admin</MenuItem>
              <MenuItem value="staff">Staff</MenuItem>
            </Select>
          </FormControl>

          <DialogActions sx={{ justifyContent: "flex-end" }}>
            <Button variant="outlined" onClick={onClose}>
              Cancel
            </Button>
            <Button variant="contained" type="submit" disabled={!!passwordError}>
              Save
            </Button>
          </DialogActions>
        </Stack>
      </form>

      {/* Snackbar */}
      <Snackbar
        open={snackbar.open}
        autoHideDuration={3000}
        onClose={handleCloseSnackbar}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'center' }}
      >
        <Alert onClose={handleCloseSnackbar} severity={snackbar.severity} sx={{ width: '100%' }}>
          {snackbar.message}
        </Alert>
      </Snackbar>
    </>
  );
}

export default StaffForm;
