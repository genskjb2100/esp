<!DOCTYPE html>
<html>
<head>
	<title>EMAPTA Staffing Plus - Client Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- CSS are placed here. For Bootstrap -->
	{!!html_entity_decode(HTML::style('css/bootstrap.css'))!!}
	{!!html_entity_decode(HTML::style('css/bootstrap-theme.css'))!!}
	{!!html_entity_decode(HTML::style('css/esp_fonts.css'))!!}
	
	{!!html_entity_decode(HTML::style('css/sticky_footer.css'))!!}
	
	{!!html_entity_decode(HTML::style('css/bootstrap_multi_level_menus.css'))!!}
	
	<!-- override bootstrap's default font family -->
	{!!html_entity_decode(HTML::style('css/esp_client_login.css'))!!}
	
	<!-- Include jQuery. For Bootstrap -->
	{!!html_entity_decode(HTML::script('js/jquery-2.1.3.min.js'))!!}
	
</head>

<body>
<!-- Container -->
<div class="container-fluid">

	<center>
		{!!html_entity_decode(HTML::image('img/esp_logo.png', 'Emapta Staffing Plus', array('class' => 'fluid-image logo-login')))!!}
	</center>
	<!-- Content -->
	@yield('content')
</div>

<!-- Scripts are placed here. For Bootstrap -->

{!!html_entity_decode(HTML::script('js/bootstrap.min.js'))!!}
</body>
</html>