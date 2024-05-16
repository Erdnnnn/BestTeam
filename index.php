<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Manager</title>
<link rel="stylesheet" href="task.css">
</head>
<body>
 
<div class="App">
    <div class="taskHeader">
        <h1>Task Manager</h1>
    </div>
 
    <div class="taskForm">
        <input type="text" class="taskNameInput" placeholder="Task Name">
        <select class="taskPrioritySelect">
            <option value="low">Low Priority</option>
            <option value="medium">Medium Priority</option>
            <option value="high">High Priority</option>
        </select>
        <input type="date" class="taskDeadlineInput">
        <button class="addTaskButton">Add Task</button>
    </div>

    <table class="taskTable">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
 
    <h2>Completed Tasks</h2>
 
    <table class="completedTable">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const taskForm = document.querySelector('.taskForm');
        const taskTableBody = document.querySelector('.taskTable tbody');
        const addTaskButton = document.querySelector('.addTaskButton');
 
        const completedTableBody = document.querySelector('.completedTable tbody');
        const taskNameInput = document.querySelector('.taskNameInput');
        const taskPrioritySelect = document.querySelector('.taskPrioritySelect');
        const taskDeadlineInput = document.querySelector('.taskDeadlineInput');
 
       
        completedTableBody.addEventListener('click', function (event){
           
            if (event.target.classList.contains('deleteTaskButton')) {
            const taskRow = event.target.closest('tr');
            taskRow.remove(); 
            }
        });
 
 
        taskTableBody.addEventListener('click', function (event) {

            if (event.target.classList.contains('markDoneButton')) {
                const taskRow = event.target.closest('tr'); 
                const taskData = {
                    name: taskRow.querySelector('td:nth-child(1)').textContent,
                    priority: taskRow.querySelector('td:nth-child(2)').textContent,
                    deadline: taskRow.querySelector('td:nth-child(3)').textContent
                };

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${taskData.name}</td>
                    <td>${taskData.priority}</td>
                    <td>${taskData.deadline}</td>
                    <td>
                        <button class="deleteTaskButton">Delete</button>
                    </td>
                `;
                completedTableBody.appendChild(newRow);

                taskRow.remove();
            }

            if (event.target.classList.contains('editTaskButton')) {
                const taskRow = event.target.closest('tr');
                const taskName = taskRow.querySelector('td:nth-child(1)').textContent;
                const taskPriority = taskRow.querySelector('td:nth-child(2)').textContent;
                const taskDeadline = taskRow.querySelector('td:nth-child(3)').textContent;

                taskNameInput.value = taskName;
                taskPrioritySelect.value = taskPriority;
                taskDeadlineInput.value = taskDeadline;
 

                taskRow.remove();
            }
            if (event.target.classList.contains('deleteTaskButton')) {
                const taskRow = event.target.closest('tr'); 
                taskRow.remove(); 
            }
        });
 
        addTaskButton.addEventListener('click', function () {
            const taskNameInput = document.querySelector('.taskNameInput');
            const taskPrioritySelect = document.querySelector('.taskPrioritySelect');
            const taskDeadlineInput = document.querySelector('.taskDeadlineInput');
 
            const taskName = taskNameInput.value;
            const taskPriority = taskPrioritySelect.value;
            const taskDeadline = taskDeadlineInput.value;
 
            if (taskName.trim() === '' || taskDeadline.trim() === '') {
                alert('Please fill in all fields.');
                return;
            }
 
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${taskName}</td>
                <td>${taskPriority}</td>
                <td>${taskDeadline}</td>
                <td>
                    <button class="markDoneButton">Mark Done</button>
                    <button class="editTaskButton">Edit</button>
                    <button class="deleteTaskButton">Delete</button>
                </td>
            `;
            taskTableBody.appendChild(newRow);

            taskNameInput.value = '';
            taskPrioritySelect.selectedIndex = 0;
            taskDeadlineInput.value = '';
        });
 
   
});
 
</script>
 
</body>
</html>