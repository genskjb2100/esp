@extends('layout.user_login')
@section('content')	

{!!html_entity_decode(Form::open(array('url' => 'user/login', 'method' => 'post', 'id' => 'login_form')))!!}

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-info">
			<div class="panel-heading" align="center">
				<h3 class="panel-title">ESP Employee Login</h3>
			</div>
			<div class="panel-body">
				<!--<form accept-charset="UTF-8" role="form">-->
				
				<div class="alert" style="display:none;">
				</div>
				
				<fieldset>
					<div class="form-group">
						<!--<input class="form-control museo_slab" placeholder="E-mail" name="email" id="email" type="text" autofocus>-->
						<input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus required />
					</div>
					<div class="form-group">
						<input class="form-control" placeholder="Password" name="password" id="password" type="password" value="" required />
					</div>
					<!--
					<div class="checkbox">
						<label>
							<input name="remember" type="checkbox" value="Remember Me"> Remember Me
						</label>
					</div>
					-->
					<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
				</fieldset>
				<!--</form>-->
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}

{!!html_entity_decode(HTML::script('js/app.js'))!!}
<script>
$(function(){
	validateIE('alert');
});
</script>
@stop