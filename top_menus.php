<h3><?php if($_SESSION["userid"]) { echo $_SESSION["name"]; } ?> | <a href="logout.php">Logout</a> </h3><br>
<p>Welcome <?php echo $_SESSION["role"]; ?></p>	
<ul class="nav nav-tabs">
	
	<?php if($_SESSION["role"] == 'superAdmin' || $_SESSION["role"] == 'Admin') { ?>
		<li id="users"><a href="users.php">Users</a></li>
		<li id="projects"><a href="projects.php">Projects</a></li> 
		<li id="tasks"><a href="tasks.php">Tasks</a></li>
		<li id="transactions"><a href="transactions.php">Transactions</a></li> 
	<?php } ?>

	<?php if($_SESSION["role"] == 'Accountable') { ?>
		
		<li id="transactions"><a href="transactions.php">Transactions</a></li> 
	<?php } ?>
	
	


</ul>