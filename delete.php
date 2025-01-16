<?php
session_start();
if(isset($_SESSION['email'])){
  include('../includes/connection.php');
  
  // Sanitize and prepare the id parameter
  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;  // Default to 0 if no ID
  
  if($id > 0) {
    // Use prepared statement to prevent SQL injection
    $query = "DELETE FROM users WHERE sno = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()){
      // Successful deletion
      echo "<script type='text/javascript'>
        alert('User deleted successfully.');
        window.location.href = 'admin_dashboard.php';
      </script>";
    } else {
      // Failed deletion
      echo "<script type='text/javascript'>
        alert('Failed to delete user. Please try again.');
        window.location.href = 'admin_dashboard.php';
      </script>";
    }
    $stmt->close();
  } else {
    echo "<script type='text/javascript'>
      alert('Invalid user ID.');
      window.location.href = 'admin_dashboard.php';
    </script>";
  }
} else {
  header('Location: ../index.php');
  exit(); // Prevent further script execution
}
?>
