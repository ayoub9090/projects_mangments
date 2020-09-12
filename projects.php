<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Project.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$project = new Project($db);


if(!$user->loggedIn()) {
	header("Location: index.php");
}

if($user->loggedIn()){
	if($_SESSION["role"] == "SubContractor" || $_SESSION["role"] == "Accountable"){
		header("Location: transactions.php");
	}
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
<script src="js/projects.js"></script>	
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
					<button type="button" id="addProject" class="btn btn-info" title="Add project"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="projectListing" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>#</th>
								
					<th>Project Name</th>					
					<th>Created by</th>	
					<th></th>	
					<th></th>	
					<th></th>						
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="projectModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="projectForm">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label for="project" class="control-label">Project Name</label>
							<input type="text" class="form-control" id="project_name" name="project_name" placeholder="project" required>			
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

	<div id="projectDetails" class="modal fade">
    	<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Project Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">Project Id:</label>
						<span id="project_id"></span>	
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
