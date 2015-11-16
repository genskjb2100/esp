<div class="panel-group" id="accordion">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a style="text-decoration: none;"  data-toggle="collapse" data-target="#collapse_ta">
					&nbsp;&nbsp;Time Amendments
				</a>
			</h3>
		</div>

		<div id="collapse_ta" class="panel-collapse collapse in">
			<div class="panel-body">
				<!-- START TABLE - Time Ammendments -->
				{!! Form::open(array('url' => 'user/request_amendment', 'method' => 'POST', 'id' => 'amendment_form')) !!}
				<div class="row" style="margin:0 auto;">
					<div >
						
						<table class="table table-hover table-condensed" id="time-amendments-table" cellspacing="0" cellpadding="0" width="100%">
							<thead class="tr_field_color">
								<tr class="tr_field_color">
									<th></th>
									<th colspan="2" class="">Original Submission</th>
									<th colspan="2" class="">Request Amendment</th>
									<th colspan="2" class="valign_mid">Notes</th>
									<th style="text-align:center;">
										<!--<button style="width:100px;" type="button" class="btn-xs btn-primary">Submit</button>-->
									</th>
								</tr>
								<tr class="tr_field_color">
									<th>Select</th>
									<th>Start</th>
									<th>Finish</th>
									<th>Start</th>
									<th>Finish</th>
									<th>Reason</th>
									<th>HR Comments</th>
									<th>Amend Status</th>
								</tr>
							</thead
							<tbody>
								@foreach ($time_records as $i => $record)
									<tr id="row_{!! $i + 1; !!}">
										<td>
											<input type="hidden" class="row_id[]" id="r_{!! $i + 1; !!}" value="{!! $i + 1; !!}" disabled required />
											<input type="checkbox" class="enable_row" id="checkbox_{!! $i + 1; !!}" {!! ($record->ta_status != "") ? "disabled" : "" !!}/>
											<input type="hidden" name="tr_id[]" class="tr_id" disabled value="{!! Crypt::encrypt($record->time_registry_id); !!}" required />
											<input type="hidden" name="ta_id[]" class="ta_id" disabled value="{!! Crypt::encrypt($record->time_ammendment_id); !!}" required />
										</td>
										<td>
											{!! date('g:i a D j M', strtotime($record->start_timestamp)) !!}
											<input type="hidden" name="start_timestamp_orig[]" value="{!! date('Y-m-d H:i:s', strtotime($record->start_timestamp)) !!}" required class="form-control original_start start_timestamp st_disp" disabled />
										</td>
										<td>
											{!! date('g:i a D j M', strtotime($record->end_timestamp)) !!}
											<input type="hidden" name="end_timestamp_orig[]" value="{!! ($record->end_timestamp != '0000-00-00 00:00:00') ? date('Y-m-d H:i:s', strtotime($record->end_timestamp)) : $record->end_timestamp; !!}" required class="form-control original_end end_timestamp" disabled />
										</td>
										<td>
											<div class="form-group">
												<input type="text" name="start_timestamp_disp[]" value="{!! (!empty($record->ammended_start)) ? date('g:i a D j M', strtotime($record->ammended_start)): (($record->ammended_start != '0000-00-00 00:00:00') ? date('g:i a D j M', strtotime($record->start_timestamp)): '');!!}" required class="form-control start_datetimepicker start_timestamp" disabled />
											</div>
										</td>
										<td>
											<div class="form-group">
												<input type="text" name="end_timestamp_disp[]" value="{!! (!empty($record->ammended_finish)) ? date('g:i a D j M', strtotime($record->ammended_finish)): (($record->end_timestamp != '0000-00-00 00:00:00') ? date('g:i a D j M', strtotime($record->end_timestamp)): '');!!}" required class="form-control end_datetimepicker end_timestamp" disabled />
											</div>
										</td>
										<td>
											<input type="text" name="user_notes[]" value="{!! $record->user_notes !!}" class="form-control user_notes" required disabled/>
										</td>
										<td>
											<input type="text" name="hr_comments[]" value="{!! $record->hr_comments !!}" class="form-control hr_comments" disabled readonly/>
										</td>
										<td class="amend_status">
											{!! $record->ta_status !!}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<button class="btn btn-info pull-right" id="request_amendment" disabled>Request Amendment</button>
				</div>
				{!! Form::close(); !!}
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(function () {
    	$("#time-amendments-table").on('click', '.enable_row', function(e){
    		if($("#time-amendments-table").find('input.enable_row:checked').length > 0){
    			$("#request_amendment").prop("disabled", false);
    		}else{
    			$("#request_amendment").prop("disabled", true);
    		}
    	 	var id = $(this).attr("id").substr(9);
    	 	var elems = $("#row_"+id+ " .end_timestamp, #row_"+id+ " .start_timestamp, #row_"+id+ " .user_notes, #row_"+id+ " .tr_id, #row_"+id+ " .ta_id");
    	 	if($(this).is(":checked")){
    	 		elems.prop("disabled", false);
    	 	}else{
    	 		elems.prop("disabled", true);
    	 	}
        	//console.log($(this).attr("id"));
        });

		$('.start_datetimepicker, .end_datetimepicker').datetimepicker({
			format: 'h:mm a ddd D MMM' // 9:42 am Thu 7 May
		});
		$("#amendment_form").submit(function(e){
			var $this = $(this);
			e.preventDefault();
			var _token = $("[name=_token]").val();
			var orig_start =[];
			var orig_end = [];
			var amend_start = [];
			var amend_end = [];
			var user_notes = [];
			var tr_id = [];
			var ta_id = [];

			//console.log($(".start_datetimepicker:not([disabled])").length);
			$(".original_start:not([disabled])").each(function(i){
				orig_start.push($(this).val());
			});

			$(".original_end:not([disabled])").each(function(i){
				orig_end.push($(this).val());
			});
			
			$(".start_datetimepicker:not([disabled])").each(function(i){
				var tmp = moment($(this).val(), 'h:mm a ddd D MMM').format("YYYY-MM-DD HH:mm:ss");
				amend_start.push(tmp);
			});

			$(".end_datetimepicker:not([disabled])").each(function(i){
				var tmp = moment($(this).val(), 'h:mm a ddd D MMM').format("YYYY-MM-DD HH:mm:ss");
				amend_end.push(tmp);
			});

			$(".user_notes:not([disabled])").each(function(i){
				user_notes.push($(this).val());
			});

			$(".tr_id:not([disabled])").each(function(i){
				tr_id.push($(this).val());
			});

			$(".ta_id:not([disabled])").each(function(i){
				ta_id.push($(this).val());
			});

			data = {
				"_token" : _token,
				"tr_id" : tr_id,
				"ta_id" : ta_id,
				"original_start" : orig_start,
				"original_end" : orig_end,
				"ammended_start" : amend_start,
				"ammended_end" : amend_end,
				"user_notes" : user_notes,
			}
			
			$.ajax({
				url: $this.attr("action"),
				type: $this.attr("method"),
				data: data,
			}).done(function(obj){
				$.each(obj.callback_data, function(x,y){
					$("#row_"+(x+1)+" .amend_status").html(y.status);
				});
			});
		});
    });
</script>