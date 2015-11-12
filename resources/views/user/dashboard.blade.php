@extends('layout.user')

@section('content')	

<div class="container container-spacer">
	<div class="row">
		<div class="col-md-6" align="middle" style="float:none;margin: 0 auto;">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">EMPLOYEE TIME CLOCK</h3>
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
							<div class="alert alert-warning" id="op_alert" role="alert" {!! ($op_what == "FINISHED" || $op_what == "TO_START") ? 'style="display:none;"' : ''; !!}>
								{!! $sched_status[$op_what] !!}
							</div>
							<input {!! ($op_what == "FINISHED" || $op_what == "FINISHED_ONCE")? 'disabled="disabled"': ''; !!} {!! ($op_what == "FINISHED_ONCE")? 'style="display:none"' :''!!} class="btn btn-lg btn-success btn-block" type="button" id="send_request" data-value="{!! ($op_what == 'TO_START') ? 1 : 0; !!}"  value="{!! ($op_what == 'TO_START')? 'Start Day' : 'Finish Day' !!}">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('user.time_amendments')
	
</div>


<input type="hidden" id="servertime" value="{!! time() !!}" />
<input type="hidden" id="servertime_ajax" value="" />
<input type="hidden" id="tr_id" value="{!! Crypt::encrypt($time_registry_id) !!}" />
<input type="hidden" id="_token" name="_token" value="<?php echo csrf_token(); ?>">
{!!html_entity_decode(HTML::script('js/jqClock.min.js'))!!}
{!!html_entity_decode(HTML::script('js/moment.js'))!!}
{!!html_entity_decode(HTML::script('js/analog_clock.js'))!!}

<script language="javascript">
var _token = $("#_token").val();

// Initialize Analog Interactive Clock
function Clock_dg(prop) {
    var angle = 360/60,
        date = new Date();
	var h = date.getHours();
    if(h > 12) {
        h = h - 12;
    }

    hour = h;
	minute = 57,
    second = date.getSeconds(),
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
	$("#send_request").click(function(e){
		var what = $(this).attr('data-value');
		var tr_id = $("#tr_id").val();
		$.ajax({
			url : "{!! url('user/time_entry') !!}",
			type: 'post',
			data : { 'what' : what, '_token' : _token, 'tr_id' : tr_id },
		}).done(function(obj){
			if(obj.status == "success"){
				$("#tr_id").val(obj.tr_id);
				$("#op_alert").html(obj.msg).show();
				switch(obj.op_what){
					case 'FINISHED': 
						$("#top_alert").hide();
						$("#send_request").attr("data-value", 0).prop('disabled', true).hide();
					break;
					case 'FINISHED_ONCE':
						$("#send_request").attr("data-value", 0).prop('disabled', true).hide();
					break;
					case 'FINISHED_FORGOT':
						$("#send_request").attr("data-value", 1).prop('disabled', false).show().val('Start day');
						$("#op_alert").delay(1000).fadeOut(600);
					break;
					case 'STARTED':
						$("#send_request").attr("data-value", 0).prop('disabled', false).show().val('Finish day');;
					break;
				}
			}
		});
	});
});
</script>
@stop