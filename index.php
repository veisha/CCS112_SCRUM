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

// Fetch all tasks from the database
$sql = "SELECT Task_ID, Task_Title, Task_Description, Task_DueDate, Task_Status FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>TMS (Task Management System)</h1>

  <nav>
      <input type="search" id="search-input" placeholder="Search tasks">
      <button id="search-button">Search</button> 
  </nav>

  <button id="addTaskButton">Add Task</button>

  <!-- Task form -->
  <div id="taskForm" style="display:none;" class="popup">
      <form action="addTask.php" method="post">
          <label for="taskTitle">Task Title:</label>
          <input type="text" id="taskTitle" name="taskTitle" required><br>

          <label for="taskDescription">Task Description:</label>
          <textarea id="taskDescription" name="taskDescription" required></textarea><br>

          <label for="dueDate">Due Date:</label>
          <input type="date" id="dueDate" name="dueDate" required><br>

          <button type="submit" id="saveTaskButton">Save Task</button>
          <button type="button" id="closeTaskForm">Close</button>
      </form>
  </div>

  <!-- Task Table -->
  <table border="1">
      <thead>
          <tr>
              <th>Task ID</th>
              <th>Task Name</th>
              <th>Task Description</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          <?php
          // Check if there are any tasks in the database
          if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["Task_ID"] . "</td>";
                  echo "<td>" . $row["Task_Title"] . "</td>";
                  echo "<td>" . $row["Task_Description"] . "</td>";
                  echo "<td>" . $row["Task_DueDate"] . "</td>";
                  echo "<td>" . $row["Task_Status"] . "</td>";
                  echo "<td>";
                  echo "<button class='editBtn'>Edit</button>";
                  echo "<button class='deleteBtn'>Delete</button>";
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
  // Handle form visibility using JavaScript
  document.getElementById("addTaskButton").addEventListener("click", () => {
      document.getElementById("taskForm").style.display = "block";
  });

  document.getElementById("closeTaskForm").addEventListener("click", () => {
      document.getElementById("taskForm").style.display = "none";
  });
  </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
