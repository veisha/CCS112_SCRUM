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

// Fetch the task details
$sql = "SELECT * FROM tasks WHERE Task_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $taskId);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task</h1>

    <form action="updateTask.php" method="post">
        <input type="hidden" name="taskId" value="<?php echo $task['Task_ID']; ?>">
        <label for="taskTitle">Task Title:</label>
        <input type="text" id="taskTitle" name="taskTitle" value="<?php echo $task['Task_Title']; ?>" required><br>

        <label for="taskDescription">Task Description:</label>
        <textarea id="taskDescription" name="taskDescription" required><?php echo $task['Task_Description']; ?></textarea><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" name="dueDate" value="<?php echo $task['Task_DueDate']; ?>" required><br>

        <button type="submit">Update Task</button>
    </form>

</body>
</html>
