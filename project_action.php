<?php
include_once 'config/Database.php';
include_once 'class/project.php';

$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listProject') {
	$project->listProjects();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addProject') {	
	
	$project->project_name = $_POST["project_name"];
	$project->user_id = $_SESSION["userid"];
	$project->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getProject') {
	$project->id = $_POST["id"];
	$project->getProject();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateProject') {
	$project->id = $_POST["id"];
	$project->project_name = $_POST["project_name"];

	$project->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteProject') {
	$project->id = $_POST["id"];
	$project->delete();
}

?>