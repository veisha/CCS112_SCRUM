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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="navSidebar">
        <nav>
        <button id="closeNav" >&#8801</button>
        <form action="search.php" method="post">
        <input type="search" id="search-input" name="searchTerm" placeholder="Search tasks" required>
        <button type="submit" id="search-button" style="background: #b6ff00; border-radius: 1px;  border: 2px solid #2C2C2C;">Search</button>
        </form>
    </nav>
    </div>
    <button id="openNav" >&#8801</button> 
    <h1 align="center">TMS (Task Management System)</h1>
  <button id="addTaskButton" class="add_button">Add Task</button>

  <!-- Task form -->
  <div id="taskForm" style="display:none;" class="popup">
      <form action="addTask.php" method="post">
          <label for="taskTitle">Task Title:</label>
          <input type="text" id="taskTitle" name="taskTitle" required><br>

          <label for="taskDescription">Task Description:</label>
          <textarea id="taskDescription" name="taskDescription" required></textarea><br>

          <label for="dueDate">Due Date:</label>
          <input type="date" id="dueDate" name="dueDate" required><br>

          <button type="submit" id="saveTaskButton" style="background: #b6ff00; border-radius: 5px;  border: 2px solid #2C2C2C">Save Task</button>
          <button type="button" id="closeTaskForm"style="background: #b6ff00; border-radius: 5px;  border: 2px solid #2C2C2C">Close</button>
      </form>
  </div>

  <!-- Edit Task Popup -->
  <div id="editTaskForm" style="display:none; " class="popup">
      <form action="updateTask.php" method="post">
          <input type="hidden" id="editTaskId" name="taskId" required maxlength="10">
          <label for="editTaskTitle">Task Title:</label>
          <input type="text" id="editTaskTitle" name="taskTitle" required><br>

          <label for="editTaskDescription">Task Description:</label>
          <textarea id="editTaskDescription" name="taskDescription" required></textarea><br>

          <label for="editDueDate">Due Date:</label>
          <input type="date" id="editDueDate" name="dueDate" required><br>

          <button type="submit" style="background: #b6ff00; border-radius: 5px;  border: 2px solid #2C2C2C">Update Task</button>
          <button type="button" id="closeEditTaskForm" style="background: #b6ff00; border-radius: 5px;  border: 2px solid #2C2C2C">Back</button>
      </form>
  </div>
  

  <!-- Task Table -->
  
<div id="tableDIV">
        <table border="1">
              <thead>
              <tr>
              <th class="idT">Task ID</th>
              <th class="TaskN">Task Name</th>
              <th class="TaskD">Task Description</th>
              <th class="TaskDt">Due Date</th>
              <th class="TaskS">Status</th>
              <th class="TaskA">Actions</th>
             </tr>
        </thead>
         <tbody>
          <?php
            // Check if there are any tasks in the database
          if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                  //Limiting the string length for tasktTitle to 15, and taskDescription to 45
                $taskTitle = (strlen($row["Task_Title"]) > 15) ? substr($row["Task_Title"], 0, 15) . '...' : $row["Task_Title"];
                $taskDescription = (strlen($row["Task_Description"]) > 45) ? substr($row["Task_Description"], 0, 45) . '...' : $row["Task_Description"];

                echo "<tr>";
                echo "<td>" . $row["Task_ID"] . "</td>";
                echo "<td>" . $taskTitle . "</td>";
                echo "<td>" . $taskDescription . "</td>";
                echo "<td>" . $row["Task_DueDate"] . "</td>";
                echo "<td>" . $row["Task_Status"] . "</td>";
                echo "<td>";
                echo "<button onclick='openEditPopup(" . $row["Task_ID"] . ", `" . $row["Task_Title"] . "`, `" . $row["Task_Description"] . "`, `" . $row["Task_DueDate"] . "`) 'style='element.style { background: #b6ff00; border: 3px solid #2C2C2C; }; background: #b6ff00; border: 2px solid #2C2C2C;'> Edit</button>";
                echo "<button onclick='deleteTask(" . $row["Task_ID"] . ")'style='element.style { background: #b6ff00; border: 3px solid #2C2C2C; }; background: #b6ff00; border: 2px solid #2C2C2C;'
>Delete</button>";
                echo "</td>";
                echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No tasks found</td></tr>";
          }
           ?>
      </tbody>
    </table>
</div>

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

<!--JQuery Part Here-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script></script>
<script>
$(document).ready(function(){
  $("#openNav").click(function(){
    $(".navSidebar").show();
    document.getElementById("tableDIV").style.marginLeft = "8%";
  });
});
$(document).ready(function(){
  $("#closeNav").click(function(){
    $(".navSidebar").hide();
    document.getElementById("tableDIV").style.marginLeft = "0";
  });
});
</script>

<?php
// Close the database connection
$conn->close();
?>