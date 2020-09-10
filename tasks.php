<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Tasks.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$task = new Tasks($db);


if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" >  
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/tasks.js"></script>	
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container">  
	<?php include('top_menus.php'); ?>
	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addTask" class="btn btn-info" title="Add task"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="taskListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
								
					<th>Task Description</th>					
					<th>Related Project</th>	

					<th></th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="taskModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="taskForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group"
							<label for="task_description" class="control-label">Task Description</label>
							<input type="text" class="form-control" id="task_description" name="task_description" placeholder="Task Description" required>			
						</div>
					
						<div class="form-group"
							<label for="task_description" class="control-label">Related to project:</label>
							<select class="form-control" name="project_id" id="project_id" require>
								<option value="">choose project</option>
								<?php 
							$result = $task->projectList();
							while ($project = $result->fetch_assoc()) { 	
							?>
								<option value="<?php echo $project['id']; ?>"><?php echo ucfirst($project['project_name']) ?></option>							
							<?php } ?>
							</select>
						</div>
				
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="id" id="id" />
    					<input type="hidden" name="action" id="action" value="" />
    					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

	<div id="taskDetails" class="modal fade">
    	<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Task Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">Task Id:</label>
						<span id="task_id"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">Task Description:</label>
						<span id="tname"></span>	
					</div>

					<div class="form-group">
						<label for="name" class="control-label">Project Name:</label>
						<span id="pname"></span>	
					</div>
							
				</div>    				
			</div>    		
    	</div>
    </div>
	
</div>
 <?php include('inc/footer.php');?>
