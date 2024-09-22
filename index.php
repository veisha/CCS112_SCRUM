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

  <!-- Edit Task Popup -->
  <div id="editTaskForm" style="display:none;" class="popup">
      <form action="updateTask.php" method="post">
          <input type="hidden" id="editTaskId" name="taskId">
          <label for="editTaskTitle">Task Title:</label>
          <input type="text" id="editTaskTitle" name="taskTitle" required><br>

          <label for="editTaskDescription">Task Description:</label>
          <textarea id="editTaskDescription" name="taskDescription" required></textarea><br>

          <label for="editDueDate">Due Date:</label>
          <input type="date" id="editDueDate" name="dueDate" required><br>

          <button type="submit">Update Task</button>
          <button type="button" id="closeEditTaskForm">Back</button>
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
  // Handle form visibility using JavaScript
  document.getElementById("addTaskButton").addEventListener("click", () => {
      document.getElementById("taskForm").style.display = "block";
  });

  document.getElementById("closeTaskForm").addEventListener("click", () => {
      document.getElementById("taskForm").style.display = "none";
  });

  // Open Edit Task Popup and populate with data
  function openEditPopup(taskId, taskTitle, taskDescription, dueDate) {
      document.getElementById("editTaskId").value = taskId;
      document.getElementById("editTaskTitle").value = taskTitle;
      document.getElementById("editTaskDescription").value = taskDescription;
      document.getElementById("editDueDate").value = dueDate;

      document.getElementById("editTaskForm").style.display = "block";
  }

  // Close Edit Task Popup
  document.getElementById("closeEditTaskForm").addEventListener("click", () => {
      document.getElementById("editTaskForm").style.display = "none";
  });

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
