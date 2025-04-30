import { Dialog, DialogTitle, DialogContent, DialogContentText, DialogActions, Button, Slide } from "@mui/material";
import { forwardRef } from "react";

// Animation transition
const Transition = forwardRef(function Transition(props, ref) {
  return <Slide direction="up" ref={ref} {...props} />;
});

function ConfirmDialog({ open, title, message, onConfirm, onCancel }) {
  return (
    <Dialog
      open={open}
      onClose={onCancel}
      TransitionComponent={Transition} // <-- Slide up effect
      keepMounted
      aria-labelledby="confirm-dialog-title"
      aria-describedby="confirm-dialog-description"
    >
      <DialogTitle id="confirm-dialog-title">{title}</DialogTitle>
      <DialogContent>
        <DialogContentText id="confirm-dialog-description">
          {message}
        </DialogContentText>
      </DialogContent>
      <DialogActions sx={{ padding: '16px' }}>
        <Button onClick={onCancel} variant="outlined" color="inherit">
          Cancel
        </Button>
        <Button onClick={onConfirm} variant="contained" color="error">
          Confirm Delete
        </Button>
      </DialogActions>
    </Dialog>
  );
}

export default ConfirmDialog;
