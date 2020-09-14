<?php
class Users {	
   
	private $usersTable = 'pm_users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listUsers(){
		$this->user_role =  htmlspecialchars(strip_tags($this->user_role));
		$this->user_id =  htmlspecialchars(strip_tags($this->user_id));


		$sqlQuery = "SELECT u.first_name,u.last_name,u.id,u.email,u.phone,u.date_created,u.address,u.role,
		uu.first_name as ufirst_name,uu.last_name as ulast_name FROM ".$this->usersTable. " u 
		LEFT JOIN ". $this->usersTable ." uu ON uu.id = u.added_by_id
		";

		if($this->user_role !== "superAdmin" && empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(u.added_by_id = "'. $this->user_id .'") ';	
		}


		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(u.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR u.email LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR u.first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR u.last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR u.role LIKE "%'.$_POST["search"]["value"].'%") ';	
			
			if($this->user_role !== "superAdmin"){
				$sqlQuery .= 'AND (u.added_by_id = "'. $this->user_id .'") ';	
			}	
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY u.date_created DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->usersTable." ");
		//$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($user = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $user['id'];
			$rows[] = ucfirst($user['first_name']);
			$rows[] = ucfirst($user['last_name']);
			$rows[] = $user['email'];	
			$rows[] = $user['phone'];	
			$rows[] = $user['address'];	
			$rows[] = $user['role'];
			$rows[] = $user['ufirst_name']." ".$user['ulast_name'];

			$rows[] = '<button type="button" name="view" id="'.$user["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View"></span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$user["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$user["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
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
	
		if($this->email) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->usersTable."( `email`,`password`,`first_name`, `last_name`, `role`,`address`,`phone`,`added_by_id`)
			VALUES(?,?,?,?,?,?,?,?)");
			
			$this->first_name = htmlspecialchars(strip_tags($this->first_name));
			$this->last_name = htmlspecialchars(strip_tags($this->last_name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->role = htmlspecialchars($this->role);
			$this->password = htmlspecialchars(strip_tags($this->password));
			$this->phone = htmlspecialchars(strip_tags($this->phone));
			$this->address = htmlspecialchars(strip_tags($this->address));
			$this->added_by_id = htmlspecialchars(strip_tags($this->added_by_id));

			$stmt->bind_param("ssssssss",  $this->email,$this->password,$this->first_name, $this->last_name, $this->role,$this->address,$this->phone,$this->added_by_id);
		
		

			if($stmt->execute()){
				return true;
			}		
		}
	}
	

	
	public function getUser(){
		if($this->id) {
			$sqlQuery = "
				SELECT id, email, first_name, last_name, role, address, phone, password FROM ".$this->usersTable." 
				WHERE id = ?";			
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
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->usersTable." 
			SET first_name= ?, last_name = ?, email = ?, role = ?, password = ?, address = ?, phone = ?
			WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->first_name = htmlspecialchars(strip_tags($this->first_name));
			$this->last_name = htmlspecialchars(strip_tags($this->last_name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->role = htmlspecialchars($this->role);
			$this->password = htmlspecialchars(strip_tags($this->password));				
			$this->phone = htmlspecialchars(strip_tags($this->phone));
			$this->address = htmlspecialchars(strip_tags($this->address));

			$stmt->bind_param("sssssssi", $this->first_name, $this->last_name, $this->email, $this->role, $this->password,$this->address, $this->phone, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->usersTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}
}
?>