<?php
//front end here...


//changes

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
  <div id="taskForm" class="popup">
        <h2>Add New Task</h2>
        <label for="taskTitle">Title:</label>
        <input type="text" id="taskTitle" name="taskTitle"><br><br>

        <label for="taskDescription">Description:</label>
        <textarea id="taskDescription" name="taskDescription"></textarea><br><br>

        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" name="dueDate"><br><br>

        <button id="saveTaskButton">Save Task</button>
        <button id="closeTaskForm">Close</button>
    </div>
        
        <script src="script.js"></script>
    


<table>
    <thead>
      <tr>
        <th>Tasks</th>
      </tr>
    </thead>
</table>

</body>
</html>