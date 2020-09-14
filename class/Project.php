<?php
class Project {	
   
	private $projectTable = 'pm_projects';
	private $usersTable = 'pm_users';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listProjects(){
		$this->user_role =  htmlspecialchars(strip_tags($this->user_role));
		$this->user_id =  htmlspecialchars(strip_tags($this->user_id));

		$sqlQuery = "SELECT p.id,p.project_name,p.user_id,u.first_name,u.last_name
		FROM " . $this->projectTable." p
		LEFT JOIN ". $this->usersTable ." u ON u.id = p.user_id
		";
		if($this->user_role !== "superAdmin" && empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(p.user_id = "'. $this->user_id .'") ';	
		}
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(p.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR p.project_name LIKE "%'.$_POST["search"]["value"].'%" ';						
			$sqlQuery .= ' OR u.first_name LIKE "%'.$_POST["search"]["value"].'%" )';	
			
			if($this->user_role !== "superAdmin"){
				$sqlQuery .= 'AND (p.user_id = "'. $this->user_id .'") ';	
			}					
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY p.date_created DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->projectTable);
		//$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($project = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $project['id'];
			$rows[] = ucfirst($project['project_name']);
			$rows[] = ucfirst($project['first_name'].' '.$project['last_name']);

			$rows[] = '<button type="button" name="view" id="'.$project["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View"></span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$project["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$project["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
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
	
		if($this->project_name) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->projectTable."( `project_name`,`user_id`)
			VALUES(?,?)");
			
			$this->project_name = htmlspecialchars(strip_tags($this->project_name));
		

			$stmt->bind_param("ss",  $this->project_name,$this->user_id);
		
		

			if($stmt->execute()){
				return true;
			}		
		}
	}
	

	
	public function getProject(){
		if($this->id) {
			$sqlQuery = "
				SELECT id, project_name FROM ".$this->projectTable." 
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
			UPDATE ".$this->projectTable." 
			SET project_name= ?
			WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->project_name = htmlspecialchars(strip_tags($this->project_name));
		

			$stmt->bind_param("si", $this->project_name, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->projectTable." 
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