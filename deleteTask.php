<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taskdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get task ID from the query string
$taskId = $_GET['id'];

// Prepare the SQL query to delete the task
$sql = "DELETE FROM tasks WHERE Task_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taskId);

if ($stmt->execute()) {
    // Redirect back to the main page
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
