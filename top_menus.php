<h3><?php if($_SESSION["userid"]) { echo $_SESSION["name"]; } ?> | <a href="logout.php">Logout</a> </h3><br>
<!-- <p>Welcome <?php  $_SESSION["role"]; ?></p>	 -->
<ul class="nav nav-tabs">
	
	<?php if($_SESSION["role"] == 'superAdmin' || $_SESSION["role"] == 'Admin') { ?>
		<li id="users"><a href="users.php">Users</a></li>
		<li id="projects"><a href="projects.php">Projects</a></li> 
		<li id="tasks"><a href="tasks.php">Tasks</a></li>
		<li id="transactions"><a href="transactions.php">Transactions</a></li> 
	<?php } ?>

	<?php if($_SESSION["role"] == "SubContractor") { ?>
		
		<li id="transactions"><a href="transactions.php">Transactions</a></li> 
		
	<?php } ?>
	
	<?php if($_SESSION["role"] == 'Accountable' || $_SESSION["role"] == 'superAdmin') { ?>
		<li id="payment_transactions"><a href="payment_transactions.php">Payment Transactions</a></li> 
		
		<li id="summary_report"><a href="summary_report.php">Summary Report</a></li> 
	<?php } ?>


</ul>