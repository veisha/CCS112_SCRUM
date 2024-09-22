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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect updated task data
    $taskId = $_POST['taskId'];
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];
    $dueDate = $_POST['dueDate'];

    // Prepare the SQL query to update the task
    $sql = "UPDATE tasks SET Task_Title = ?, Task_Description = ?, Task_DueDate = ? WHERE Task_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $taskTitle, $taskDescription, $dueDate, $taskId);

    if ($stmt->execute()) {
        // Redirect to the main page
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
