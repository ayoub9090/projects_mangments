$(document).ready(function () {
	var urlPath = window.location.pathname,
		urlPathArray = urlPath.split('.'),
		tabId = urlPathArray[0].split('/').pop();
	$('#clients, #projects,#transactions').removeClass('active');
	$('#' + tabId).addClass('active');


	$('div[id^="expand"]').click(function () {
		$(this).next().show();
	})

	function removeURLParameter(url, parameter) {
		
		//prefer to use l.search if you have a location/link object
		var urlparts= url.split('?');   
		if (urlparts.length>=2) {
	
			var prefix= encodeURIComponent(parameter)+'=';
			var pars= urlparts[1].split(/[&;]/g);
	
			//reverse iteration as may be destructive
			for (var i= pars.length; i-- > 0;) {    
				//idiom for string.startsWith
				if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
					pars.splice(i, 1);
				}
			}
	
			url= urlparts[0]+'?'+pars.join('&');
			return url;
		} else {
			return url;
		}
	}

	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	if (getUrlVars().fromDate != undefined ){
		var fromDateRange = getUrlVars().fromDate;
		fromDateRange = decodeURIComponent(fromDateRange);
		console.log(fromDateRange);

	}
	if (getUrlVars().toDate != undefined ){
		var toDateRange = getUrlVars().toDate;
		toDateRange = decodeURIComponent(toDateRange);
		console.log(toDateRange);

	}
	
	// if the Accountent selected a specific date will be as query string 
	// if he didn't select will be the initials values
	var _startDate = (fromDateRange != undefined ? fromDateRange : '2017/01/01')
	var _endtDate = (toDateRange != undefined ? toDateRange : new Date())
	
	$('input[name="fromDate"]').daterangepicker({
		locale: {
			format: "YYYY/MM/DD",
		},
		singleDatePicker: true,
		showDropdowns: true, // to ability select years and month from dropdown list
		startDate:_startDate, // as client request 
		endDate: _startDate, 
		minDate:'2017/01/01',
		maxDate: new Date(),



	});
	$('input[name="toDate"]').daterangepicker({
		locale: {
			format: "YYYY/MM/DD",
		},
		singleDatePicker: true,
		showDropdowns: true, // to ability select years and month from dropdown list
		startDate: _endtDate, // as client request 
		minDate:'2017/01/01',
		maxDate: new Date(),


	});
	$('.resetDate').on('click',function(){
		window.location = window.location.href.split("?")[0];
	})
	// Transaction Date
	$('input[name="date_of_intall"]').datepicker({
		format: 'yyyy/mm/dd',
		// startDate: new Date()
	});
	/*$("#taskListing").on('click', 'span[id^="task_"]', function(){
		
		$(this).slideToggle();
	}); */

});