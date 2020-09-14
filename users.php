<?php
include_once 'config/Database.php';
include_once 'class/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

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
<title>Users</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/users.js"></script>	
<script src="js/general.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" >  
<?php include('inc/container.php');?>
<div class="container">  
	<?php include('top_menus.php'); ?>	
	<div class="table-responsive"> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2 text-right">
					<button type="button" id="addUser" class="btn btn-info add" title="Add User"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="userListing" class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>#</th>
										
					<th>First Name</th>					
					<th>Last Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Role</th>
					<th>Created by</th>										
					<th></th>
					<th></th>	
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="userModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="userForm"  >
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label for="name" class="control-label">First Name</label>
							<input type="text" class="form-control" id="first_name" name="first_name"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Last Name</label>
							<input type="text" class="form-control" id="last_name" name="last_name"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Email</label>
							<input type="text" class="form-control" id="email" name="email"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Phone</label>
							<input type="text" class="form-control" id="phone" name="phone"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Address</label>
							<input type="text" class="form-control" id="address" name="address"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Password</label>
							<input type="text" class="form-control" id="password" name="password"  required>			
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Role</label>
							<select class="form-control" required  id="role" name="role">

							<?php if($_SESSION["role"] == 'Admin'){ ?>
								<option selected value="SubContractor">SubContractor</option>
							<?php } ?>
							<?php if($_SESSION["role"] == 'superAdmin'){ ?>
								<option value="Admin" selected>Admin</option>
								<option value="Accountable">Accountable</option>
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
	
	<div id="userDetails" class="modal fade">
    	<div class="modal-dialog">    		
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> User Details</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name" class="control-label">First Name:</label>
						<span id="fname"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">Last Name:</label>
						<span id="lname"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">email:</label>
						<span id="uemail"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">phone:</label>
						<span id="uphone"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">address:</label>
						<span id="uaddress"></span>	
					</div>
					<div class="form-group">
						<label for="name" class="control-label">Role:</label>
						<span id="urole"></span>	
					</div>

				</div>    				
			</div>    		
    	</div>
    </div>
	
</div>
 <?php include('inc/footer.php');?>
