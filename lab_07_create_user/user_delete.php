<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'initialize.php';

// Check if the user-id was passed in the URL
if (isset($_GET['user-id'])) {
    $id = intval($_GET['user-id']);
    
    // Delete the record from the database
    $sql = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($connection, $sql)) {
        $_SESSION['alert_message'] = "User deleted successfully!";
        // Redirect back to the records table using JavaScript
        echo "<script>
                window.location.href = '../lab_08_read_user_records/user_records.php';
              </script>";
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
} else {
    // If no ID was provided, just send them back to the table
    echo "<script>
            window.location.href = '../lab_08_read_user_records/user_records.php';
          </script>";
    exit();
}
?>