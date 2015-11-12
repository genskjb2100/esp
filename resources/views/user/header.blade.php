<p class="bg-primary hidden" id="message-board">Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top museo_slab navbar-inverse" id="topnavbar" style="font-weight:bold;">
	<div class="container" style="width:95%;">
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
			<div class="nav navbar-nav navbar-right" style="padding-top:15px;">
				<span style="color:white;">Logged in as {!! Session::get('nickname') !!} </span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo link_to('user/logout', 'Logout', $attributes = array(), $secure = null); ?>
			</div>
		</div>
	</div>
</nav>

<script type="text/javascript">
$(document).ready(function(){
    $("#expand_all").click(function(){
        $("#collapseOne").collapse('hide');
		//$("#collapseTwo").collapse('hide');
    });
    var fix_navbar_pos = parseFloat($("#message-board").offset().top) + $("#message-board").height();
   $("#topnavbar").offset({top : fix_navbar_pos});
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
