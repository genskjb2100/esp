<!DOCTYPE html>
<html>
<head>
	<title>EMAPTA Staffing Plus - Employee Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- CSS are placed here. For Bootstrap -->
	{!!html_entity_decode(HTML::style('css/bootstrap.css'))!!}
	{!!html_entity_decode(HTML::style('css/bootstrap-theme.css'))!!}
	{!!html_entity_decode(HTML::style('css/esp_fonts.css'))!!}
	
	{!!html_entity_decode(HTML::style('css/sticky_footer.css'))!!}
	
	{!!html_entity_decode(HTML::style('css/bootstrap_multi_level_menus.css'))!!}
	
	
	
	<!-- Include jQuery. For Bootstrap -->
	{!!html_entity_decode(HTML::script('js/jquery-2.1.3.min.js'))!!}
	
	
	<!-- START Include Bootstrap Data Tables Initialize. For displaying of good tables -->
	{!!html_entity_decode(HTML::style('css/dataTables.bootstrap.css'))!!}
	{!!html_entity_decode(HTML::script('js/jquery.dataTables.min.js'))!!}
	{!!html_entity_decode(HTML::script('js/dataTables.bootstrap.js'))!!}
	{!!html_entity_decode(HTML::script('js/data_tables_initialize.js'))!!}
	<!-- END Include Bootstrap Data Tables Initialize. For displaying of good tables -->
	
	{!!html_entity_decode(HTML::style('css/analog_clock.css'))!!}
	{!!html_entity_decode(HTML::style('css/jqClock.css'))!!}
	<!-- override bootstrap's default font family -->
	{!!html_entity_decode(HTML::style('css/esp_user.css'))!!}
</head>

<body>
<!-- Header Main Menu -->
@include('user.header')


<!-- Content -->
@yield('content')

<!-- Footer -->
@yield('footer')


<!-- Scripts are placed here. For Bootstrap -->
{!!html_entity_decode(HTML::script('js/bootstrap.min.js'))!!}

{!!html_entity_decode(HTML::script('js/bootstrap-editable.min.js'))!!}
{!!html_entity_decode(HTML::script('js/moment.js'))!!}

{!!html_entity_decode(HTML::script('js/transition.js'))!!}
{!!html_entity_decode(HTML::script('js/collapse.js'))!!}
{!!html_entity_decode(HTML::script('js/bootstrap-datetimepicker.js'))!!}
{!!html_entity_decode(HTML::style('css/bootstrap-datetimepicker.min.css'))!!}



{!!html_entity_decode(HTML::script('js/pnotify.all.min.js'))!!}
{!!html_entity_decode(HTML::style('css/pnotify.all.min.css'))!!}

</body>
</html>