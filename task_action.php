<?php
include_once 'config/Database.php';
include_once 'class/Tasks.php';

$database = new Database();
$db = $database->getConnection();

$task = new Tasks($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listTask') {
	$task->user_role = $_SESSION["role"];
	$task->user_id = $_SESSION["userid"];
	
	$task->listTasks();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addTask') {	
	
	$task->task_description = $_POST["task_description"];
	$task->project_id = $_POST["project_id"];

	$task->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTask') {
	$task->id = $_POST["id"];
	$task->getTask();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateTask') {
	$task->id = $_POST["id"];
	$task->task_description = $_POST["task_description"];
	$task->project_id = $_POST["project_id"];

	$task->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteTask') {
	$task->id = $_POST["id"];
	$task->delete();
}

?>