<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Transaction.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$transaction = new Transaction($db);


if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<title></title>
<link href="css/style.css" rel="stylesheet" type="text/css" >
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/transaction.js"></script>
<script src="js/general.js"></script>
<?php include('inc/container.php');?>
<div class="container">
    <?php include('top_menus.php'); ?>

    <?php if($_SESSION["role"] == 'Accountable'){ ?>
    <form action="">
        <!-- <div class="form-group--select"> -->
        <div class="row ">
            <div class="col-sm-1">
                <h3 class="m-0">Filters</h3>
            </div>
            <div class="col-sm-11 filters ">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="main_sub_con_name">By Subcontractor Name :</label>
                        <select class="form-control" name="sub_con" id="main_sub_con_name" >
                            <option value="">Select Sub contractor to view</option>
                            <?php 
                            $result3 = $transaction->subContractorList();
                            while ($subCon = $result3->fetch_assoc()) { 	
                            ?>
                            <?php if(isset($_GET["sub_con"]) && $subCon['id'] == $_GET["sub_con"]){ ?>
                            <option selected value="<?php echo $subCon['id']; ?>">
                                <?php echo ucfirst($subCon['first_name']).' '.ucfirst($subCon['last_name']) ;?></option>
                            <?php }else{ ?>
                            <option value="<?php echo $subCon['id']; ?>">
                                <?php echo ucfirst($subCon['first_name']).' '.ucfirst($subCon['last_name']) ;?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <!-- <label for="daterange">By Date Range :</label> -->

                        <div class="form-group">
                            <label for="fromDate">From Date:</label>
                            <input type="text" name="fromDate" class="form-control w-100 dateRange" value="" />
                        </div>
                        <div class="form-group">
                            <label for="toDate">To Date:</label>
                            <input type="text" name="toDate" class="form-control w-100 dateRange" value="" />
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="submit" style="opacity:0;visibility:hidden">x</label>
                            <input type="submit" class="btn select-main_sub_con_name btn-primary btn-block w-100" value="View Filtered Results" />
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn  btn-danger btn-block resetDate text-black" >
                                Clear All Filters
                            </button>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>

<?php } ?>

<div> 	
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-10">
                <h3 class="panel-title"></h3>
            </div>
            <div class="col-md-2 text-right">
                <?php if($_SESSION["role"] !== 'Accountable'){ ?>
                <button type="button" id="addTransaction" class="btn btn-info add" title="Add transaction"><span class="glyphicon glyphicon-plus"></span></button>
                <?php } ?>
                
            </div>
        </div>
	</div>
    <div class="table-responsive w-100"> 	
		<table id="transactionListing" class="table table-bordered table-striped table-hover <?php echo strtolower($_SESSION["role"]) ?>">
			<thead>
				<tr>
					<th>#</th>

					<th>Site Name</th>
					<th>Site NO</th>
					<th>Sub-Con Name</th>
					<th>Date of Installation</th>
					<th>Project Name</th>
					<th>Task Description</th>
					<th>IM Name</th>
					<th>Notes</th>
					<th>Status</th>
					<th>Work Amount</th>
					<th>Payment Amount</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
			</thead>

			<?php if($_SESSION["role"] == 'Accountable'){ ?>
			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th  style="text-align:right">Total:</th>
					<th style="text-align:right">Total:</th>
					<th></th>
					<th></th>
					<th></th>


				</tr>
				<tr>
					<th colspan="15" class="balance" style="text-align:right">Balance:</th>

				</tr>
			</tfoot>
			<?php } ?>
		</table>
	</div>
    
</div>
<div id="transactionModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="transactionForm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Record</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="transaction" class="control-label">Site Name</label>
                        <input type="text" class="form-control" id="site_name" name="site_name" placeholder="site name" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction" class="control-label">Site NO</label>
                        <input type="text" class="form-control" id="site_id" name="site_id" placeholder="site id" required>
                    </div>
                    <div class="form-group">
                      

						<?php if($_SESSION["role"] == 'SubContractor'){  ?>
							<input type="text" style="display:none;" class="form-control" id="sub_con_name" name="sub_con_name" value="<?php echo $_SESSION["userid"]; ?>" placeholder="" required>
						<?Php }else{ ?>
							<label for="transaction" class="control-label">Sub-Con Name</label>
                        <select  class="form-control" name="sub_con_name" id="sub_con_name" required>
                            <option value="">select subContractor</option>
                            <?php 
							$result = $transaction->subContractorList();
							while ($subCon = $result->fetch_assoc()) { 	
							?>
                            <?php if($_SESSION["role"] == 'SubContractor' && $subCon['id'] == $_SESSION["userid"]){ ?>
                            <option selected value="<?php echo $subCon['id']; ?>"><?php echo ucfirst($subCon['first_name']).' '.ucfirst($subCon['last_name']); ?></option>
                            <?php }else{ ?>
                            <option value="<?php echo $subCon['id']; ?>"><?php echo ucfirst($subCon['first_name']).' '.ucfirst($subCon['last_name']); ?></option>
                            <?php }
							} 
							?>
						</select>
						
						<?php } ?>
                    </div>

                    <div class="form-group">
                        <label for="task_description" class="control-label">Project Name</label>
                        <select class="form-control" name="project_id" id="project_id" required>
                            <option value="">select project</option>
                            <?php 
							$result = $transaction->projectList();
							while ($project = $result->fetch_assoc()) { 	
							?>
                            <option value="<?php echo $project['id']; ?>"><?php echo ucfirst($project['project_name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="task_description" class="control-label">Task Description</label>
                        <select class="form-control" name="task_id" id="task_id" required>
                            <option value="">select task</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="task_description" class="control-label">IM Name</label>
                        <select class="form-control" name="im_id" id="im_id" required>
                            <option value="">select IM</option>
                            <?php 
							$result2 = $transaction->imList();
							while ($im = $result2->fetch_assoc()) { 	
							?>
                            <option value="<?php echo $im['id']; ?>"><?php echo ucfirst($im['first_name']).' '.ucfirst($im['last_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transaction" class="control-label">Date of installation</label>
                        <input type="text" class="form-control" id="date_of_intall" name="date_of_intall" placeholder="Date of installation" required>
                    </div>
 

                    <div class="form-group">
                        <label for="transaction" class="control-label">Note</label>
                        <input type="text" class="form-control" id="note" name="note" placeholder="note" >
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

<div id="transactionDetails" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Transaction Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="control-label">Transaction Id:</label>
                    <span id="transaction_id"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Site Name:</label>
                    <span id="vsite_name"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Site No:</label>
                    <span id="vsite_id"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Sub Contractor Name:</label>
                    <span id="vsub_con_name"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Notes:</label>
                    <span id="vnotes"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Date of installation:</label>
                    <span id="vdate_of_install"></span>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Project Name:</label>
                    <span id="vproject_name"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Task Name:</label>
                    <span id="vtask_name"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">IM Name:</label>
                    <span id="vim_name"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Status:</label>
                    <span id="vstatus"></span>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Reason:</label>
                    <span id="vreason"></span>
                </div>

                <input type="hidden" name="transID" id="transID" value="" />

                <form method="post" onsubmit="return submitStatus()" id="transactionApproveForm" style="<?php if($_SESSION["role"] !== 'Admin' && $_SESSION["role"] !== 'superAdmin'){ echo 'display:none'; } ?>" >
                    <div class="btn-group">
                        <div class="inputGroup">
                            <input id="approved" name="status"  value="approved" checked type="radio"/>
                            <label for="approved">Approve</label>
                        </div>
                        <div class="inputGroup inputGroup-reject">
                            <input id="rejected" name="status" value="rejected" type="radio"/>
                            <label for="rejected">Reject</label>
                        </div>
                    </div>

                    <div class="form-group amount-box">
                        <label for="name" class="control-label">Insert Work Amount: <small class="color-danger">required if approved</small></label>
                        <input class="form-control" type="number" id="work_amount" value="0" name="work_amount" />
                    </div>

                    <div class="form-group reason-box">
                        <label for="name" class="control-label">Reason of Rejection: <small class="color-danger">required if reject</small></label>
                        <textarea class="form-control" id="rejectReason" name="status_note"></textarea>
                    </div>


                    <div class="btn-group mb-3">
                        <button type="button"  class="btn statUpdate btn-success" data-dismiss="modal">Submit</button>
                    </div>

                </form>


                <form method="post" id="accountable_area" style="<?php if($_SESSION["role"] !== 'Accountable'){ echo 'display:none'; } ?>">

                    <input id="acc_ID" type="hidden" name="acc_ID" value="0"  />
                    <div class="form-group ">
                        <label for="name" class="control-label">Insert Payment Amount:</label>
                        <input class="form-control" type="number" id="payment_amount" value="0" name="payment_amount" />
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Note:</label>
                        <textarea class="form-control" id="acc_note" name="acc_note"></textarea>
                    </div>


                    <div class="btn-group mb-3">
                        <button type="button"  class="btn accountableUpdate btn-success">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

</div>
<?php include('inc/footer.php');?>