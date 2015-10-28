
function start_get_latest_time(_token) {
	$.ajax({
		url: 'get_latest_time',
		type: 'POST', 
		cache: false, 
		data: { 
			_token: _token
			//clock_time: $('.clocktime').html()
			//clock_time: latest_time
		},
		success: function(data) {
			$("#servertime_ajax").val(data);
			do_start_day(_token, data);
		},
		error: function() {
			//$('#notification-bar').text('An error occurred');
		}
	});
}

function finish_get_latest_time(_token) {
	$.ajax({
		url: 'get_latest_time',
		type: 'POST', 
		cache: false, 
		data: { 
			_token: _token
			//clock_time: $('.clocktime').html()
			//clock_time: latest_time
		},
		success: function(data) {
			$("#servertime_ajax").val(data);
			do_finish_day(_token, data);
		},
		error: function() {
			//$('#notification-bar').text('An error occurred');
		}
	});
}

function do_start_day(_token, latest_time) {
	$.ajax({
		url: 'start_day',
		type: 'POST', 
		cache: false, 
		data: { 
			_token: _token, 
			//clock_time: $('.clocktime').html()
			clock_time: latest_time
		},
		success: function(data) {
			// disable the Start Day button
			//$("#start_day").prop('disabled', true);
			$("#start_day").hide();
			$('.log-time-start').show().html('Successfully Logged In at ' + data);
			
			setTimeout(function() {
					location.reload();
			}, 2000);
		},
		error: function() {
			//$('#notification-bar').text('An error occurred');
		}
	});
}

function do_finish_day(_token, latest_time) {
	$.ajax({
		url: 'finish_day',
		type: 'POST', 
		cache: false, 
		data: { 
			_token: _token, 
			//clock_time: $('.clocktime').html()
			clock_time: latest_time
		},
		success: function(data) {
			//$("#finish_day").prop('disabled', true);
			$("#finish_day").hide();
			$('.log-time-finish').show().html('Successfully Logged Out at ' + data);
			
			//setTimeout(function() {
			//	location.reload();
			//}, 2000);
		},
		error: function() {
			//$('#notification-bar').text('An error occurred');
		}
	});
}

$(function() {
	// start ajax
	$("#start_day").click(function() {
		$('.log-time-start, .log-time-finish, .alert-warning').hide();
		var _token = $("#_token").val();
		start_get_latest_time(_token);
		var latest_time = $("#servertime_ajax").val();
	});
	
	$("#finish_day").click(function() {
		$('.log-time-start, .log-time-finish, .alert-warning').hide();
		var _token = $("#_token").val();
		finish_get_latest_time(_token);
		var latest_time = $("#servertime_ajax").val();
	});
	
	$("#destroyclock1").click(function(){ $("#clock1").clock("destroy") });
});