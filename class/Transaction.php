<?php
class Transaction {	
   
	private $transactionTable = 'pm_transaction';
	private $projectTable = 'pm_projects';
	private $taskTabel = 'pm_tasks';
	private $userTable = 'pm_users';
	private $accountTable = 'pm_accounts';
	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listTransaction(){
		$this->user_role =  htmlspecialchars(strip_tags($this->user_role));
		$this->user_id =  htmlspecialchars(strip_tags($this->user_id));

		$sqlQuery = "SELECT trans.id,trans.site_name,trans.site_id,
		trans.date_of_installation,trans.status,trans.status_note,trans.work_amount,
		trans.created_by_id,trans.sub_con_name,trans.notes,trans.date_created,
		t.id as task_id,t.task_description,p.id as project_id,
		p.project_name,u.first_name, u.last_name,sc.first_name as scfirst_name,sc.last_name as sclast_name, sc.id as scid FROM ".$this->transactionTable." trans
		LEFT JOIN ". $this->projectTable ." p ON p.id = trans.project_id 
		LEFT JOIN ". $this->taskTabel ." t ON t.id = trans.task_id
		LEFT JOIN ". $this->userTable ." u ON u.id = trans.im_id
		LEFT JOIN ". $this->userTable ." sc ON sc.id = trans.sub_con_name
		";



		if($this->user_role == "SubContractor" && empty($_POST["search"]["value"])){
			//$sqlQuery .= 'where(trans.created_by_id = "'. $this->user_id .'") ';	
			$sqlQuery .= 'where(trans.sub_con_name = "'. $this->user_id .'") ';	
		}

		if($this->user_role == "Admin" && empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(trans.im_id = "'. $this->user_id .'") ';	
		}

		if($this->user_role == "Accountable" && empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(trans.status = "Approved") ';	
			if($this->sub_con_id){
				$this->sub_con_id = htmlspecialchars(strip_tags($this->sub_con_id));	
				$sqlQuery .= 'AND (trans.sub_con_name = '.$this->sub_con_id.') ';
			}
			if($this->filterDateFrom){
				$this->filterDateFrom = htmlspecialchars(strip_tags($this->filterDateFrom));
				$this->filterDateTo = htmlspecialchars(strip_tags($this->filterDateTo));	
				$sqlQuery .= 'AND (cast(trans.date_created as date)  between "'.$this->filterDateFrom.'" and "'.$this->filterDateTo.'") ';
			}

		}

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(trans.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR trans.site_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR trans.site_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR p.project_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.task_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR u.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR sc.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR sc.last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR trans.status LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR trans.work_amount LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR trans.date_of_installation LIKE "%'.$_POST["search"]["value"].'%") ';
			if($this->user_role == "SubContractor"){
				//$sqlQuery .= 'AND (trans.created_by_id = "'. $this->user_id .'") ';	
				$sqlQuery .= 'AND (trans.sub_con_name = "'. $this->user_id .'") ';	
			}
			if($this->user_role == "Admin"){
				$sqlQuery .= 'AND (trans.im_id = "'. $this->user_id .'") ';	
			}

			if($this->user_role == "Accountable"){
				$sqlQuery .= 'AND (trans.status = "Approved") ';	

				if($this->sub_con_id && $this->sub_con_id > 0){
					$this->sub_con_id = htmlspecialchars(strip_tags($this->sub_con_id));	
					$sqlQuery .= 'AND (trans.sub_con_name = '.$this->sub_con_id.') ';
				}

				if($this->filterDateFrom){
					$this->filterDateFrom = htmlspecialchars(strip_tags($this->filterDateFrom));
					$this->filterDateTo = htmlspecialchars(strip_tags($this->filterDateTo));	
					
					$sqlQuery .= 'AND (cast(trans.date_created as date)  between "'.$this->filterDateFrom.'" and "'.$this->filterDateTo.'") ';
				}

			}

		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY trans.date_created DESC ';
		}
		$sqlQueryTotal = $sqlQuery;
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		//$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->transactionTable);
		$stmtTotal = $this->conn->prepare($sqlQueryTotal);
		

		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($transaction = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $transaction['id'];
			$rows[] = ucfirst($transaction['site_name']);
			$rows[] = ucfirst($transaction['site_id']);
			$rows[] = ucfirst($transaction['scfirst_name']).' '.ucfirst($transaction['sclast_name']);
			
			$rows[] = date("yy-m-d", strtotime($transaction['date_of_installation'])); ;
			$rows[] = ucfirst($transaction['project_name']);
			$rows[] = ucfirst($transaction['task_description']);
			$rows[] = ucfirst($transaction['first_name'].' '.$transaction['last_name']);		
			$rows[] = ucfirst($transaction['notes']);
			$rows[] = ucfirst($transaction['status']);
			$rows[] = ucfirst($transaction['work_amount']);
			
			
			$rows[] = '<button type="button" name="view" id="'.$transaction["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View"></span></button>';			
			if(($transaction['status'] == "approved"  || $transaction['status'] == "pending") && $_SESSION["role"] == "SubContractor"){
				$rows[] = '-';
			}else{
				$rows[] = '<button type="button" name="update" id="'.$transaction["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			}

			$rows[] = '<button type="button" name="delete" id="'.$transaction["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}
	



	public function insert(){
	
		if($this->site_name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->transactionTable."(`site_name`, `site_id`, `sub_con_name`, `notes`, `date_of_installation`, `project_id`, `task_id`, `im_id`,`created_by_id`)
			VALUES(?,?,?,?,?,?,?,?,?)");
			$this->created_user_id = htmlspecialchars(strip_tags($this->created_user_id));	
			$this->site_name = htmlspecialchars(strip_tags($this->site_name));
			$this->site_id = htmlspecialchars(strip_tags($this->site_id));
			$this->sub_con_name = htmlspecialchars(strip_tags($this->sub_con_name));
			$this->project_id = htmlspecialchars(strip_tags($this->project_id));
			$this->task_id = htmlspecialchars(strip_tags($this->task_id));
			$this->im_id = htmlspecialchars(strip_tags($this->im_id));
			$this->date_of_intall =  $this->date_of_intall;
			$this->note = htmlspecialchars(strip_tags($this->note));

			$stmt->bind_param("sssssssss",  $this->site_name,$this->site_id ,$this->sub_con_name,$this->note,$this->date_of_intall,$this->project_id,$this->task_id,$this->im_id,$this->created_user_id);
		
	
			if($stmt->execute()){

				$uquery = "SELECT u.id,u.first_name,u.last_name,uu.id as sub_id,u.email,uu.first_name as sub_first_name,uu.first_name as sub_last_name,
				uu.email as sub_email 
				from ". $this->userTable ." u
				LEFT JOIN ". $this->userTable ." uu ON uu.id = ".$this->sub_con_name.
				" Where  u.id = ". $this->im_id;

				$stmt = $this->conn->prepare($uquery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$row = $result->fetch_row();
				
				$imName  = $row[1].' '.$row[2];
				$email  = $row[4];
				$subName =  $row[5].' '.$row[6];
				
				//echo $imName.' '.$email;

				$this->sendMail('add',$imName,	$subName,$email);
				return true;
				
			}

				
				return true;
			}		
		}


	public function getTransaction(){
		if($this->id) {
			$sqlQuery = "SELECT trans.id,trans.site_name,trans.site_id,
			trans.date_of_installation,
			trans.sub_con_name,trans.notes, trans.status,trans.status_note,trans.work_amount,
			t.id as task_id,t.task_description,p.id as project_id,
			p.project_name,u.id as im_id,u.first_name,
			sc.first_name as scfirst_name,sc.last_name as sclast_name,sc.id as scid FROM ".$this->transactionTable." trans 
			LEFT JOIN ". $this->projectTable ." p ON p.id = trans.project_id 
			LEFT JOIN ". $this->taskTabel ." t ON t.id = trans.task_id
			LEFT JOIN ". $this->userTable ." u ON u.id = trans.im_id
			LEFT JOIN ". $this->userTable ." sc ON sc.id = trans.sub_con_name
			WHERE trans.id = ?";		
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}

	public function update(){
		
		if($this->id) {			
			if($_SESSION["role"] == "SubContractor"){
				$cc = "status='pending',";
			}else{
				$cc = "";
			}
			$stmt = $this->conn->prepare("
			UPDATE ".$this->transactionTable." 
			SET ". $cc ." site_name= ?,site_id= ?, sub_con_name=?, notes=?, date_of_installation=?, project_id=?, task_id=?, im_id=?
			WHERE id = ?");

			

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->site_name = htmlspecialchars(strip_tags($this->site_name));
			$this->site_id = htmlspecialchars(strip_tags($this->site_id));
			$this->sub_con_name = htmlspecialchars(strip_tags($this->sub_con_name));
			$this->project_id = htmlspecialchars(strip_tags($this->project_id));
			$this->task_id = htmlspecialchars(strip_tags($this->task_id));
			$this->im_id = htmlspecialchars(strip_tags($this->im_id));
			$this->date_of_intall =  $this->date_of_intall;
			$this->note = htmlspecialchars(strip_tags($this->note));

			$stmt->bind_param("ssssssssi",  $this->site_name,$this->site_id ,$this->sub_con_name, $this->note, $this->date_of_intall,$this->project_id,$this->task_id,$this->im_id,$this->id);
		
		
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->transactionTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}


	function projectList(){		
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->projectTable." ORDER BY date_created DESC");				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

	function taskList(){	
		if($this->id) {	
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->taskTabel." WHERE project_id = ? ORDER BY date_created DESC");		
		$stmt->bind_param("i", $this->id);		
		$stmt->execute();			
		$result = $stmt->get_result();		

		$records = array();	
		while ($task = $result->fetch_assoc()) { 				
			
			$records[] = $task;
		}
		echo json_encode($records);
		
		}	
	}

	function imList(){	
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->userTable." WHERE `role` = 'Admin'");				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;
	}


	function subContractorList(){	
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->userTable." WHERE `role` = 'SubContractor'");				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;
	}


	public function updateStatus(){
		
		if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->transactionTable." 
			SET status= ?,work_amount= ?, status_note=? 
			WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->work_amount = htmlspecialchars(strip_tags($this->work_amount));
			$this->rejectReason = htmlspecialchars(strip_tags($this->rejectReason));
		

			$stmt->bind_param("sssi",  $this->status, $this->work_amount ,$this->rejectReason,$this->id);
		
		
			
			if($stmt->execute()){
				$uquery = "SELECT t.id,t.sub_con_name,u.first_name,u.last_name ,u.email
				from ". $this->transactionTable ." t
				LEFT JOIN ". $this->userTable ." u ON u.id = t.sub_con_name 
				Where  t.id = ". $this->id;

				$stmt = $this->conn->prepare($uquery);
				$stmt->execute();
				$result = $stmt->get_result();	
				$row = $result->fetch_row();
				$name = $row[2].' '.$row[3];
				$email  = $row[4];
				//echo $email;
				$this->updateStatusMail($this->status,$email,$name,$this->rejectReason);
			
				echo true;
			}
			
		}	
	}


	public function insertPaymentAmount(){
		
		if($this->id) {			
			if($this->acc_id > 0){
				$stmt = $this->conn->prepare("
				UPDATE ".$this->accountTable." 
				SET payment_amount= ?,notes= ? 
				WHERE id = ?");
				

				$this->id = htmlspecialchars(strip_tags($this->id));
				$this->user_id = strip_tags($this->user_id);
				$this->payment_amount = htmlspecialchars(strip_tags($this->payment_amount));
				$this->notes = htmlspecialchars(strip_tags($this->notes));
				$this->acc_id = htmlspecialchars(strip_tags($this->acc_id));


				$stmt->bind_param("ssi", $this->payment_amount ,$this->notes,$this->acc_id);
			
				if($stmt->execute()){
					echo true;
				}
		}else{
	
				$stmt = $this->conn->prepare("
				INSERT INTO ".$this->accountTable." (`payment_amount`, `the_current_date`,`notes`,`user_id`,`transaction_id`)
				VALUES (?, NOW(),?,?,?)
				");

				$this->id = htmlspecialchars(strip_tags($this->id));
				$this->user_id = strip_tags($this->user_id);
				$this->payment_amount = htmlspecialchars(strip_tags($this->payment_amount));
				$this->notes = htmlspecialchars(strip_tags($this->notes));
				$this->acc_id = htmlspecialchars(strip_tags($this->acc_id));


				$stmt->bind_param("ssss", $this->payment_amount ,$this->notes,$this->user_id,$this->id);
			
				if($stmt->execute()){
					echo true;
				}
			}
		}	
	}

	public function updateStatusMail($status,$email,$subName,$reason){
		
		$to = $email;
		$subject = "ses-jo - Transaction updated";
	
if($status == "approved"){
		$message = "
				<html>
				<head>
				<title>Notification Email</title>
				</head>
				<body>
				<p><b>Dear ".$subName."</b>,<br/> A transaction has been approved.,<br/> 
				<p><a href='http://pmo.ses-jo.com/'>click here to visit website and check your transactions</a></p>
				
				</body>
				</html>
				";
}else{
	$message = "
	<html>
	<head>
	<title>Notification Email</title>
	</head>
	<body>
	<p><b>Dear ".$subName."</b>,<br/> A transaction has been rejected.,<br/> 
	<p><a href='http://pmo.ses-jo.com/'>click here to visit website and check your transactions</a></p>
	<br/>
	<h4>Reason of rejected</h4>
	<p>".$reason."</p>
	</body>
	</html>
	";
}

				
			

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <subconstructor@ses-jo.com>' . "\r\n";
			//$headers .= 'Cc: subconstructor@ses-jo.com' . "\r\n";

			mail($to,$subject,$message,$headers);
	}


	
	public function sendMail($action,$imName,$subName,$email){
		
		$to = $email;
		$subject = "ses-jo - Transaction added";
	

		$message = "
				<html>
				<head>
				<title>Notification Email</title>
				</head>
				<body>
				<p><b>Dear ".$imName."</b>,<br/> A transaction has been added by ".$subName.",<br/> 
				<p><a href='http://pmo.ses-jo.com/'>click here to visit website</a></p>
				
				</body>
				</html>
				";


				
			

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <subconstructor@ses-jo.com>' . "\r\n";
			//$headers .= 'Cc: subconstructor@ses-jo.com' . "\r\n";

			mail($to,$subject,$message,$headers);
	}


}
?>