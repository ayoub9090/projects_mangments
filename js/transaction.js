$(document).ready(function () {
	var the_task;

	var options = [{
		"targets": [0, 12, 13, 14],
		"orderable": false,
	}];

	if (role === "Accountable") {
		options = [{
			"targets": [13, 14],
			"visible": false
		}, {
			"targets": [0, 12],
			"orderable": false
		}];
	}

	var transactionRecords = $('#transactionListing').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5'
		],
		'serverMethod': 'post',
		"order": [],

		"ajax": {
			url: "transaction_action.php",
			type: "POST",
			data: { action: 'listTransaction' },
			dataType: "json"
		},
		"columnDefs":
			options
		,
		"pageLength": 10
	});

	$('#addTransaction').click(function () {
		$('#transactionModal').modal({
			backdrop: 'static',
			keyboard: false
		});


		setTimeout(function () {
			$('#transactionForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Transaction");
			$('#action').val('addTransaction');
			task_id = 0;
			$('#task_id').val("");
			$('#save').val('Save');

		}, 700)
	});

	$("#transactionListing").on('click', '.update', function () {
		var id = $(this).attr("id");
		var action = 'getTransaction';
		$.ajax({
			url: 'transaction_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#transactionModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#site_id').val(data.site_id);
					$('#site_name').val(data.site_name);
					$('#sub_con_name').val(data.sub_con_name);
					$('#sub_con_name').val(data.sub_con_name);
					$('#project_id').val(data.project_id);
					the_task = data.task_id;
					$("#project_id").change();

					$('#task_id').val(data.task_id);
					$('#im_id').val(data.im_id);
					$('#date_of_intall').val(data.date_of_installation);
					$('#note').val(data.notes);

					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Transaction");
					$('#action').val('updateTransaction');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#transactionModal").on('submit', '#transactionForm', function (event) {
		event.preventDefault();
		$('#save').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "transaction_action.php",
			method: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
				$('#transactionForm')[0].reset();
				$('#transactionModal').modal('hide');
				$('#save').attr('disabled', false);
				transactionRecords.ajax.reload();
			}
		})
	});

	$("#transactionListing").on('click', '.delete', function () {
		var id = $(this).attr("id");
		var action = "deleteTransaction";
		if (confirm("Are you sure you want to delete this transaction?")) {
			$.ajax({
				url: "transaction_action.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					transactionRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$("#transactionListing").on('click', '.view', function () {
		var id = $(this).attr("id");
		var action = 'getTransaction';
		$.ajax({
			url: 'transaction_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#transactionDetails").on("shown.bs.modal", function () {
					$('#transID').val(data.id);
					$("#transaction_id").html(data.id);
					$('#vsite_name').html(data.site_name);
					$('#vsite_id').html(data.site_id);
					$('#vsub_con_name').html(data.sub_con_name);
					$('#vnotes').html(data.notes);
					$('#vdate_of_install').html(data.date_of_installation);
					$('#vproject_name').html(data.project_name);
					$('#vtask_name').html(data.task_description);
					$('#vim_name').html(data.first_name);
					$('#vstatus').html(data.status);
					$('#work_amount').val(data.work_amount);
					$("input[name=status]").val(data.status);
					$('#' + data.status).click();
					$('#rejectReason').val(data.status_note);
					$('#payment_amount').val(data.payment_amount);
					$('#acc_note').val(data.accnotes);
					$('#acc_ID').val(data.accID);
				}).modal();
			}
		});
	});

	$("#project_id").change(function (t) {

		var id = $('#project_id').val();
		if (id !== '') {
			var action = 'getTaskList';
			$.ajax({
				url: 'transaction_action.php',
				method: "POST",
				data: { id: id, action: action },
				dataType: "json",
				success: function (data) {
					console.log(data);
					$('#task_id').find('option')
						.remove()
						.end();

					$('#task_id').append('<option value="">select task</option>');
					$.each(data, function (i) {
						if (the_task > 0 && data[i].id === the_task) {
							$('#task_id').append('<option selected value="' + data[i].id + '">' + data[i].task_description + '</option>');
						} else {
							$('#task_id').append('<option value="' + data[i].id + '">' + data[i].task_description + '</option>');
						}
					});


				}
			});
		}
	});

	$('input[type=radio][name=status]').change(function () {
		if (this.value == 'rejected') {
			$('.amount-box').hide();
			$('#work_amount').val('0');
			$('.reason-box').fadeIn(200);
		}
		else if (this.value == 'approved') {
			$('.reason-box').hide();
			$('#rejectReason').val();
			$('.amount-box').fadeIn(200);
		}
	});

	$('.statUpdate').click(function () {
		var id = $('#transID').val();
		var work_amount = $('#work_amount').val();
		var rejectReason = $('#rejectReason').val();
		var status = $("input[name=status]:checked").val();


		var action = 'statusChange';

		if (status === 'approved' && work_amount <= 0) {
			alert('please insert work amount');
			return false;
		}
		if (rejectReason === '' && status === 'rejected') {
			alert('please insert reject reason');
			return false;
		}

		$.ajax({
			url: 'transaction_action.php',
			method: "POST",
			data: { id: id, work_amount, rejectReason, status, action: action },
			dataType: "json",
			success: function (data) {
				$('#transactionDetails').modal("toggle");
				transactionRecords.ajax.reload();
				console.log(data);
			}
		});

		return false;
	})


	$('.accountableUpdate').click(function () {
		var id = $('#transID').val();
		var acc_note = $('#acc_note').val();
		var payment_amount = $('#payment_amount').val();
		var action = 'insertPaymentAmount';
		var acc_ID = $('#acc_ID').val();

		if (payment_amount <= 0) {
			alert('please insert payment amount');
			return false;
		}

		$.ajax({
			url: 'transaction_action.php',
			method: "POST",
			data: { id: id, acc_note, acc_ID, payment_amount, action: action },
			dataType: "json",
			success: function (data) {
				$('#transactionDetails').modal("toggle");
				transactionRecords.ajax.reload();
				console.log(data);
			}
		});

		return false;
	})


});







