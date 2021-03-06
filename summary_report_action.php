<?php
include_once 'config/Database.php';
include_once 'class/SummaryReport.php';

$database = new Database();
$db = $database->getConnection();

$transaction = new SummaryReport($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listContractors') {
	$transaction->user_role = $_SESSION["role"];
	$transaction->user_id = $_SESSION["userid"];
	
	$transaction->sub_con_id = $_POST["mainSubContractor"];
	$transaction->filterDateFrom = $_POST["filterDateFrom"];
	$transaction->filterDateTo = $_POST["filterDateTo"];

	$transaction->listContractors();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listPayments') {
	$transaction->user_role = $_SESSION["role"];
	$transaction->user_id = $_SESSION["userid"];
	
	$transaction->sub_con_id = $_POST["mainSubContractor"];
	$transaction->filterDateFrom = $_POST["filterDateFrom"];
	$transaction->filterDateTo = $_POST["filterDateTo"];

	$transaction->listPayments();
}


if(!empty($_POST['action']) && $_POST['action'] == 'addTransaction') {	
	
	$transaction->payment_amount = $_POST["payment_amount"];
	$transaction->subcontractor_id = $_POST["sub_con_name"];
	
	$transaction->note = $_POST["note"];
	$transaction->user_id = $_SESSION["userid"];
	
	$transaction->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getTransaction') {
	$transaction->id = $_POST["id"];
	$transaction->getTransaction();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateTransaction') {
	
	$transaction->id = $_POST["id"];
	$transaction->site_name = $_POST["site_name"];
	$transaction->site_id = $_POST["site_id"];
	$transaction->sub_con_name = $_POST["sub_con_name"];
	$transaction->project_id = $_POST["project_id"];
	$transaction->task_id = $_POST["task_id"];
	$transaction->im_id = $_POST["im_id"];
	$transaction->date_of_intall = $_POST["date_of_intall"];
	$transaction->note = $_POST["note"];
	

	$transaction->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteTransaction') {
	$transaction->id = $_POST["id"];
	$transaction->delete();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getTaskList') {
	$transaction->id = $_POST["id"];
	$transaction->taskList();
}


if(!empty($_POST['action']) && $_POST['action'] == 'statusChange') {
	
	$transaction->id = $_POST["id"];
	$transaction->work_amount = $_POST["work_amount"];
	$transaction->rejectReason = $_POST["rejectReason"];
	$transaction->status = $_POST["status"];

	$transaction->updateStatus();
}


if(!empty($_POST['action']) && $_POST['action'] == 'insertPaymentAmount') {
	
	$transaction->id = $_POST["id"];
	$transaction->user_id = $_SESSION["userid"];
	$transaction->payment_amount = $_POST["payment_amount"];
	$transaction->notes = $_POST["acc_note"];
	$transaction->acc_id = $_POST["acc_ID"];
	
	

	$transaction->insertPaymentAmount();
}





?>