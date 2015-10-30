<!-- START for hover main menu dropdown effect -->
<style>
.sidebar-nav {
    padding: 9px 0;
}
.dropdown-menu .sub-menu {
    left: 100%;
    position: absolute;
    top: 0;
    visibility: hidden;
    margin-top: -1px;
}
.dropdown-menu li:hover .sub-menu {
    visibility: visible;
}
.dropdown:hover .dropdown-menu {
    display: block;
}
.nav-tabs .dropdown-menu, .nav-pills .dropdown-menu, .navbar .dropdown-menu {
    margin-top: 0;
}
.navbar .sub-menu:before {
    border-bottom: 7px solid transparent;
    border-left: none;
    border-right: 7px solid rgba(0, 0, 0, 0.2);
    border-top: 7px solid transparent;
    left: -7px;
    top: 10px;
}
.navbar .sub-menu:after {
    border-top: 6px solid transparent;
    border-left: none;
    border-right: 6px solid #fff;
    border-bottom: 6px solid transparent;
    left: 10px;
    top: 11px;
    left: -6px;
}
</style>
<!-- END for hover main menu dropdown effect -->

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top museo_slab navbar-inverse" style="font-weight:bold;">
	<div class="container" style="width:95%;">
	<!--<div class="container">-->
		<div class="navbar-header" style="margin-top:-5px;">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{URL::to('user/dashboard')}}" style="color: white !important;">
				{!!html_entity_decode(HTML::image("img/emapta_logo.png", "Emapta Logo"))!!}
			</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<!--
				<li class="active"><a href="#">Home</a></li>
				-->
				<li class="dropdown">
					<!--
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Dashboard <span class="caret"></span>
					</a>
					
					<ul class="dropdown-menu" role="menu">
						<li>{!! HTML::link('/admin/dashboard', 'Group by Company') !!}</li>
						<li>{!! HTML::link('/admin/dashboard/late_by_company', 'Late by Company') !!}</li>
						<li>{!! HTML::link('/admin/dashboard/late_by_location', 'Late by Location') !!}</li>
					</ul>
					
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li class="dropdown-submenu">
							<a href="#">Sub Menus Here Test</a>
							
							<ul class="dropdown-menu">
								<li><a href="#">Employee Set Schedule</a></li>
								<li><a href="#">Add Employees</a></li>
								<li><a href="#">Contact Emapta</a></li>
								<li class="dropdown-submenu">
									<a href="#">3rd Level Sub Menus</a>
									<ul class="dropdown-menu">
										<li><a href="#">3rd Level Hello</a></li>
										<li><a href="#">3rd Level World</a></li>
									</ul>
								</li>
							</ul>
							  
						</li>
						<li class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
					-->
				</li>
				<!--
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						Admin <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>{!! HTML::link('/admin/schedule', 'Set Employee Schedule') !!}</li>
					</ul>
				</li>
				-->
			</ul>
			
			<div class="nav navbar-nav navbar-right" style="padding-top:15px;">
				<span style="color:white;">Logged in as {!! Session::get('nickname') !!} </span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo link_to('user/logout', 'Logout', $attributes = array(), $secure = null); ?>

			</div>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<?php
//pr(Session::get(null), 1, 'blue');
// <li>Logged in as {!! Session::get('display_name') !!}<a href="logout">Logout</a></li>
?>

<script type="text/javascript">
$(document).ready(function(){
    $("#expand_all").click(function(){
        $("#collapseOne").collapse('hide');
		//$("#collapseTwo").collapse('hide');
    });
});

function toggle_expand_all(obj) {
    var $input = $(obj);
    if ($input.prop('checked')) {
		$(".panel-collapse").collapse('show');
	} else {
		$(".panel-collapse").collapse('hide');
	}
}
</script>
