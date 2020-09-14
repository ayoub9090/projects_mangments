$(document).ready(function () {
	var urlPath = window.location.pathname,
		urlPathArray = urlPath.split('.'),
		tabId = urlPathArray[0].split('/').pop();
	$('#clients, #projects,#transactions').removeClass('active');
	$('#' + tabId).addClass('active');


	$('div[id^="expand"]').click(function () {
		$(this).next().show();
	})


	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars[hash[0]] = hash[1];
		}
		return vars;
	}

	// if the Accountent selected a specific date will be as query string 
	// if he didn't select will be the initials values
	var _startDate = (getUrlVars().startDate != undefined ? getUrlVars().startDate : '01/01/2017')
	var _endtDate = (getUrlVars().endDate != undefined ? getUrlVars().endDate : new Date())
	console.log(getUrlVars())
	$(function () {
		$('input[name="daterange"]').daterangepicker({
			locale: {
				format: "DD/MM/YYYY",
			},
			opens: 'left',
			showDropdowns: true, // to ability select years and month from dropdown list
			minDate: '01/01/2017', // as client request 
			maxDate: new Date(), // today date
			startDate: _startDate,
			endDate: _endtDate,

		}, function (start, end, label) {
			$('form').submit()
		});
	});
	// Transaction Date
	$('input[name="date_of_intall"]').datepicker({
		format: 'yyyy-mm-dd',
		startDate: new Date()
	});
	/*$("#taskListing").on('click', 'span[id^="task_"]', function(){
		
		$(this).slideToggle();
	}); */

});