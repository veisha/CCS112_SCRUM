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
    $taskStatus = "Ongoing";  // Default status for the task

    // Prepare the SQL query to insert data into the tasks table
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
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
