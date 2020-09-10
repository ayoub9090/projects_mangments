$(document).ready(function () {

	var taskRecords = $('#taskListing').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": false,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "task_action.php",
			type: "POST",
			data: { action: 'listTask' },
			dataType: "json"
		},
		"columnDefs": [
			{
				"targets": [0, 3, 4, 5],
				"orderable": false,
			},
		],
		"pageLength": 10
	});

	$('#addTask').on('click', function () {

		$('#taskModal').modal({
			backdrop: 'static',
			keyboard: false
		});
		setTimeout(function () {
			$('#taskForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Task");

			$('#action').val('addTask');
			$('#save').val('Save');

		}, 700)

	});

	$("#taskListing").on('click', '.update', function () {

		var id = $(this).attr("id");
		var action = 'getTask';
		$.ajax({
			url: 'task_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				console.log(data)
				$("#taskModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#task_description').val(data.task_description);
					$('#project_id').val(data.project_id);

					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Task");
					$('#action').val('updateTask');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#taskModal").on('submit', '#taskForm', function (event) {
		event.preventDefault();
		$('#save').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "task_action.php",
			method: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
				$('#taskForm')[0].reset();
				$('#taskModal').modal('hide');
				$('#save').attr('disabled', false);
				taskRecords.ajax.reload();
			}
		})
	});

	$("#taskListing").on('click', '.delete', function () {
		var id = $(this).attr("id");
		var action = "deleteTask";
		if (confirm("Are you sure you want to delete this Task?")) {
			$.ajax({
				url: "task_action.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					taskRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$("#taskListing").on('click', '.view', function () {
		var id = $(this).attr("id");
		var action = 'getTask';
		$.ajax({
			url: 'task_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				console.log(data)
				$("#taskDetails").on("shown.bs.modal", function () {

					$('#tname').html(data.task_description);
					$('#task_id').html(data.id);
					$('#pname').html(data.project_name);
				}).modal();
			}
		});
	});

});


