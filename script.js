const addTaskButton = document.getElementById("addTaskButton");
const taskForm = document.getElementById("taskForm");
const saveTaskButton = document.getElementById("saveTaskButton");
const closeTaskForm = document.getElementById("closeTaskForm");
const taskList = document.getElementById("taskList");

addTaskButton.addEventListener("click", () => {
    taskForm.style.display = "block";
});

closeTaskForm.addEventListener("click", () => {
    taskForm.style.display = "none";
});

saveTaskButton.addEventListener("click", () => {
    const taskTitle = document.getElementById("taskTitle").value;
    const taskDescription = document.getElementById("taskDescription").value;
    const dueDate = document.getElementById("dueDate").value;

    const listItem = document.createElement("li");
    listItem.innerHTML = `
        <h3>${taskTitle}</h3>
        <p>${taskDescription}</p>
        <p>Due: ${dueDate}</p>
    `;
    taskList.appendChild(listItem);

    taskForm.style.display = "none";

    // clear the form fields
    document.getElementById("taskTitle").value = "";
    document.getElementById("taskDescription").value = "";
    document.getElementById("dueDate").value = "";
});