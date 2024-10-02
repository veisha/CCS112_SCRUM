<?php
session_start();

// Database connection details
$servername = "localhost";  // Your MySQL server (typically localhost)
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (leave it blank if none)
$dbname = "taskdb";         // The name of your database

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];
    $dueDate = $_POST['dueDate'];
    $taskStatus = "ongoing";  // Default status for the task

    // First, check if the task title already exists
    $checkSql = "SELECT * FROM tasks WHERE Task_Title = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $taskTitle);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // If the task title already exists, show a popup message
        echo "<script>
        alert('A task with this title already exists. Please choose a different title.');
        window.location.href = 'index.php';
        </script>";
    } else {
        // If the title does not exist, insert the new task
        $sql = "INSERT INTO tasks (Task_Title, Task_Description, Task_DueDate, Task_Status) 
                VALUES (?, ?, ?, ?)";

        // Prepare and bind parameters to avoid SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $taskTitle, $taskDescription, $dueDate, $taskStatus);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the main page if the insertion is successful
            header("Location: index.php");
            exit();
        } else {
            // Show a popup message for SQL error
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check statement
    $checkStmt->close();
}

$conn->close();
?>
