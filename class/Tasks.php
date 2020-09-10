<?php
class Tasks {	
   
	private $taskTable = 'pm_tasks';
	private $projectTable = 'pm_projects';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listTasks(){
		
		$sqlQuery = "SELECT t.id,t.task_description,p.project_name,p.id as project_id FROM ".$this->taskTable." t 
		LEFT JOIN ". $this->projectTable ." p
		ON p.id = t.project_id GROUP BY t.id ";
	

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(t.id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.task_description LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY t.date_created DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->taskTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($task = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $task['id'];
			$rows[] = ucfirst($task['task_description']);
			$rows[] = ucfirst($task['project_name']);

			$rows[] = '<button type="button" name="view" id="'.$task["id"].'" class="btn btn-info btn-xs view"><span class="glyphicon glyphicon-file" title="View"></span></button>';			
			$rows[] = '<button type="button" name="update" id="'.$task["id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$task["id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
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
	
		if($this->task_description) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->taskTable."( `task_description`,`project_id`)
			VALUES(?,?)");
			
			$this->task_description = htmlspecialchars(strip_tags($this->task_description));
			$this->project_id = htmlspecialchars(strip_tags($this->project_id));

			$stmt->bind_param("ss",  $this->task_description,$this->project_id);
		
		

			if($stmt->execute()){
				return true;
			}		
		}
	}
	

	
	public function getTask(){
		if($this->id) {
		
				
				$sqlQuery = "SELECT t.id,t.task_description,p.project_name,p.id as project_id FROM ".$this->taskTable." t 
				LEFT JOIN ". $this->projectTable ." p
				ON p.id = t.project_id WHERE t.id=?";
			
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
			UPDATE ".$this->taskTable." 
			SET task_description = ?,project_id = ?
			WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->project_id = htmlspecialchars(strip_tags($this->project_id));
			$this->task_description  = htmlspecialchars(strip_tags($this->task_description));
		

			$stmt->bind_param("ssi", $this->task_description,$this->project_id, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function delete(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->taskTable." 
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
	


}
?>