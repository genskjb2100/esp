@extends('layout.user')

@section('content')	

<div class="container container-spacer">
	<div class="row">
		<div class="col-md-6" align="middle" style="float:none;margin: 0 auto;">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">EMPLOYEE TIME CLOCK {!! $op_what !!}</h3>
				</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-5">
							<div id="clock">
								<div id="hour" style="transform: rotate(334.5deg);"><img src="/img/analog_clock/hourhand.png"></div>
								<div id="minute" style="transform: rotate(54deg);"><img src="/img/analog_clock/minhand.png"></div>
								<div id="second" style="transform: rotate(108deg);"><img src="/img/analog_clock/sechand.png"></div>
							</div>
						</div>
						
						<div class="col-lg-7">
							<div id="" class="jqclock">
								<span class="clockdate">{!! date("l, F j, Y") !!}</span>
							</div>
							<div class="alert alert-success log-time-start" role="alert" style="display:none;"></div>
							<div class="alert alert-success log-time-finish" role="alert" style="display:none;"></div>

							<input {!! ($op_what == "FINISHED")? 'disabled="disabled"': ''; !!} class="btn btn-lg btn-success btn-block" type="button" id="start_day" value="Start Day">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://localhost:8080/js/moment.js"></script>

<input type="hidden" id="servertime" value="{!! time() !!}" />
<input type="hidden" id="servertime_ajax" value="" />
{!!html_entity_decode(HTML::script('js/jqClock.min.js'))!!}

{!!html_entity_decode(HTML::script('js/analog_clock.js'))!!}

<script>
// Initialize Analog Interactive Clock
function Clock_dg(prop) {
    var angle = 360/60,
        date = new Date();
        var h = date.getHours();
    //alert(h);
    h = 3;
        if(h > 12) {
            h = h - 12;
        }

        hour = h;
        //minute = date.getMinutes(),
    minute = 57,
    
        second = date.getSeconds(),
    //alert(second);
    //second = 5,
        hourAngle = (360/12) * hour + (360/(12*60)) * minute;

        $('#minute')[0].style[prop] = 'rotate('+angle * minute+'deg)';
        $('#second')[0].style[prop] = 'rotate('+angle * second+'deg)';
        $('#hour')[0].style[prop] = 'rotate('+hourAngle+'deg)';
}

function refresh_digital_clock() {
  //clocktime
  
  servertime = parseFloat( $("input#servertime").val() ) * 1000;
  $('#clock1').clock({
    "calendar":"true", 
    "timestamp": servertime
  });
}
$(function(){
	refresh_digital_clock();
});
</script>
@stop