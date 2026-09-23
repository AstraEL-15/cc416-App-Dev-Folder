<?php include 'initialize.php'; ?>
<?php
$user_id = $_GET['user-id'];
$sql = "DELETE FROM users WHERE id=".$user_id;

if ($connection->query($sql) === TRUE) {
    $_SESSION['alert_message'] = "Record has been deleted";
    header('Location: ../lab_08_read_user_records/user_records.php');
    exit();
} else {
    echo "Error deleting record: " . $connection->error;
}
?>