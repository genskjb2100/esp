// returns true or false
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

// validation for Client email and password login
function validate_client_login() {	
	$('#login_form').on('submit', function() {
		var email = $('#email').val();
		var password = $('#password').val();
		var is_valid = true;
		
		if ($.trim(email) == '') {
			is_valid = false;
			$('#error_box').show();
			$('#error_message').html('Email is required.');
			$('#email').focus();
		} else if ($.trim(password) == '') {
			is_valid = false;
			$('#error_box').show();
			$('#error_message').html('Password is required.');
			$('#password').focus();
		} else {
			// validate for email format
			if (isEmail(email) === false) {
				is_valid = false;
				$('#error_box').show();
				$('#error_message').html('Invalid email format.');
				$('#email').focus();
			} else {
				is_valid = true;
			}
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

// validation for client login. Do PHP validation first then this later on.
$(function() {
	$('.alert-danger').delay(6000).fadeOut(3000);
	//$('.alert-success').delay('slow').fadeOut(3000);
	$('.client-logout').delay('slow').fadeOut(3000);
	validate_client_login();
});