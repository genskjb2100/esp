@extends('layout.client_login')
@section('content')	

{!!html_entity_decode(Form::open(array('url' => 'client/login', 'method' => 'post', 'id' => 'login_form')))!!}

<div class="row mod-top-margin">
	<div class="col-md-4 col-md-offset-4 text-center">
		<div class="mod-width">
			<div class="alert-wrapper">
			</div>
			<div class="form-group">
				<input type="text" name="username" id="username" class="form-control" placeholder="Login" autofocus required />
			</div>
			<div class="form-group">
				<input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
			</div>
			<div class="form-group">
				<input type="submit" name="login" value="Login" class="btn btn-primary" />
			</div>
			<div class="form-group text-left login-links">
				<a href="#">Forgot Password?</a>&nbsp;
				<a href="#">Questions?</a>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}

{!!html_entity_decode(HTML::script('js/client_app.js'))!!}
<script>
$(function(){
	validateIE('alert');
});
</script>
@stop