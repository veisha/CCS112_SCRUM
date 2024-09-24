<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "taskdb";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search input
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

// Search for tasks matching the search term
$sql = "SELECT Task_ID, Task_Title, Task_Description, Task_DueDate, Task_Status FROM tasks WHERE Task_Title LIKE '%$searchTerm%' OR Task_Description LIKE '%$searchTerm%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Search Results</h1>
    <button onclick="window.location.href='index.php'">Back</button>
    
    <!-- Task Table -->
    <table border="1">
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Task Title</th>
                <th>Task Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Limiting the string length for taskTitle to 15, and taskDescription to 45
                    $taskTitle = (strlen($row["Task_Title"]) > 15) ? substr($row["Task_Title"], 0, 15) . '...' : $row["Task_Title"];
                    $taskDescription = (strlen($row["Task_Description"]) > 45) ? substr($row["Task_Description"], 0, 45) . '...' : $row["Task_Description"];

                    echo "<tr>";
                    echo "<td>" . $row["Task_ID"] . "</td>";
                    echo "<td>" . $taskTitle . "</td>";
                    echo "<td>" . $taskDescription . "</td>";
                    echo "<td>" . $row["Task_DueDate"] . "</td>";
                    echo "<td>" . $row["Task_Status"] . "</td>";
                    echo "<td>";
                    echo "<button onclick='openEditPopup(" . $row["Task_ID"] . ", `" . $row["Task_Title"] . "`, `" . $row["Task_Description"] . "`, `" . $row["Task_DueDate"] . "`)'>Edit</button> ";
                    echo "<button onclick='deleteTask(" . $row["Task_ID"] . ")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No tasks found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    // Open Edit Task Popup and populate with data
    function openEditPopup(taskId, taskTitle, taskDescription, dueDate) {
        document.getElementById("editTaskId").value = taskId;
        document.getElementById("editTaskTitle").value = taskTitle;
        document.getElementById("editTaskDescription").value = taskDescription;
        document.getElementById("editDueDate").value = dueDate;
        document.getElementById("editTaskForm").style.display = "block";
    }

    // Delete Task function
    function deleteTask(taskId) {
        if (confirm("Are you sure you want to delete this task?")) {
            window.location.href = 'deleteTask.php?id=' + taskId;
        }
    }
    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
