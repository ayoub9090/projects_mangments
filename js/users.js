$(document).ready(function () {

	var userRecords = $('#userListing').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "user_action.php",
			type: "POST",
			data: { action: 'listUsers' },
			dataType: "json"
		},
		"columnDefs": [
			{
				"targets": [0, 8, 9, 10],
				"orderable": false,
			},
		],
		"pageLength": 10
	});

	$('#addUser').click(function () {
		$('#userModal').modal({
			backdrop: 'static',
			keyboard: false
		});

		setTimeout(function () {
			$('#userForm')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add User");
			$('#action').val('addUser');
			$('#save').val('Save');

		}, 700)
	});

	$("#userListing").on('click', '.update', function () {
		var id = $(this).attr("id");
		var action = 'getUser';
		$.ajax({
			url: 'user_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#userModal").on("shown.bs.modal", function () {
					$('#id').val(data.id);
					$('#first_name').val(data.first_name);
					$('#last_name').val(data.last_name);
					$('#email').val(data.email);
					$('#password').val(data.password);
					$('#phone').val(data.phone);
					$('#address').val(data.address);
					$('#role').val(data.role);
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit User");
					$('#action').val('updateUser');
					$('#save').val('Save');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#userModal").on('submit', '#userForm', function (event) {
		event.preventDefault();
		$('#save').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "user_action.php",
			method: "POST",
			data: formData,
			success: function (data) {
				console.log(data);
				$('#userForm')[0].reset();
				$('#userModal').modal('hide');
				$('#save').attr('disabled', false);
				userRecords.ajax.reload();
			}
		})
	});

	$("#userListing").on('click', '.delete', function () {
		var id = $(this).attr("id");
		var action = "deleteUser";
		if (confirm("Are you sure you want to delete this user?")) {
			$.ajax({
				url: "user_action.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					userRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

	$("#userListing").on('click', '.view', function () {
		var id = $(this).attr("id");
		var action = 'getUser';
		$.ajax({
			url: 'user_action.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (data) {
				$("#userDetails").on("shown.bs.modal", function () {

					$('#fname').html(data.first_name);
					$('#lname').html(data.last_name);
					$('#urole').html(data.role);
					$('#uemail').html(data.email);
					$('#uphone').html(data.phone);
					$('#uaddress').html(data.address);

				}).modal();
			}
		});
	});

});