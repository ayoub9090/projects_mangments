<?php
include_once 'config/Database.php';
include_once 'class/Users.php';

$database = new Database();
$db = $database->getConnection();

$user = new Users($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listUsers') {
	$user->user_role = $_SESSION["role"];
	$user->user_id = $_SESSION["userid"];
	$user->listUsers();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addUser') {	
	$user->first_name = $_POST["first_name"];
	$user->last_name = $_POST["last_name"];
	$user->email = $_POST["email"];
	$user->role = $_POST["role"];
	$user->phone = $_POST["phone"];
	$user->address = $_POST["address"];
	$user->password = md5($_POST["password"]);
	$user->ptext = $_POST["password"];
	$user->added_by_id = $_SESSION["userid"];

	$user->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getUser') {
	$user->id = $_POST["id"];
	$user->getUser();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateUser') {
	$user->id = $_POST["id"];
	$user->first_name = $_POST["first_name"];
	$user->last_name = $_POST["last_name"];
	$user->email = $_POST["email"];
	$user->role = $_POST["role"];
	$user->phone = $_POST["phone"];
	$user->address = $_POST["address"];
	$user->password =  md5($_POST["password"]);
	$user->ptext = $_POST["password"];
	$user->changePass = $_POST["changePass"];
	$user->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteUser') {
	$user->id = $_POST["id"];
	$user->delete();
}

?>