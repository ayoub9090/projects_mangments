$(document).ready(function () {

	var projectRecords = $('#projectListing').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "project_action.php",
			type: "POST",
			data: { action: 'listProject' },
			dataType: "json"
		},
		"columnDefs": [
			{
				"targets": [0, 3, 4, 5],
				"orderable": false,
			},
		],
		"pageLength": 20
	});

	$('#addProject').click(function () {
		$('#projectModal').modal({
			backdrop: 'static',
			keyboard: false
		});


		setTimeout(function () {
			$('#projectForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Project");
			$('#action').val('addProject');
			$('#save').val('Save');

		}, 700)
	});

	$("#projectListing").on('click', '.update', function () {
		var id = $(this).attr("id");
		var action = 'getProject';
		$.ajax({
			url: 'project_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#projectModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#project_name').val(data.project_name);
					//$('#project_name').val(data.project_name);

					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Project");
					$('#action').val('updateProject');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#projectModal").on('submit', '#projectForm', function (event) {
		event.preventDefault();
		$('#save').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "project_action.php",
			method: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
				$('#projectForm')[0].reset();
				$('#projectModal').modal('hide');
				$('#save').attr('disabled', false);
				projectRecords.ajax.reload();
			}
		})
	});

	$("#projectListing").on('click', '.delete', function () {
		var id = $(this).attr("id");
		var action = "deleteProject";
		if (confirm("Are you sure you want to delete this project?")) {
			$.ajax({
				url: "project_action.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					projectRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$("#projectListing").on('click', '.view', function () {
		var id = $(this).attr("id");
		var action = 'getProject';
		$.ajax({
			url: 'project_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#projectDetails").on("shown.bs.modal", function () {

					$('#pname').html(data.project_name);
					$('#project_id').html(data.id);

				}).modal();
			}
		});
	});

});