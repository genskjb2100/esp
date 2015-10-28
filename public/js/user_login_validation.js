// returns true or false
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

// validation for User username and password login
function validate_user_login() {
	$('#login_form').on('submit', function() {
		var username = $('#username').val();
		var password = $('#password').val();
		var is_valid = true;
		
		if ($.trim(username) == '') {
			is_valid = false;
			$('#error_box').show();
			$('#error_message').html('Username is required.');
			$('#username').focus();
		} else if ($.trim(password) == '') {
			is_valid = false;		
			$('#error_box').show();
			$('#error_message').html('Password is required.');
			$('#password').focus();
		} else {
			is_valid = true;
		}
		
		if (is_valid === false) {
			return false;
		} else {
			$('#error_box').hide();
			$('#error_message').hide();
			return true;
		}
	});
}

// validation for user login. Do PHP validation first then this later on.
$(function() {
	$('.alert-danger').delay(6000).fadeOut(3000);
	//$('.alert-success').delay('slow').fadeOut(3000);
	$('.user-logout').delay('slow').fadeOut(3000);
	validate_user_login();
});