@extends('layouts.default')

@section('content')
	<h2>Report Creation</h2>
	
	<p>Create a report based on the choices below.</p>
	
	<div class="col-lg-6">
	{!! Form::open(['class' => 'form-horizontal', 'url' => '/report/']) !!}
		
		<div class="form-group">
			{!! Form::label('', 'Level:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::select('report_level_id', $report_levels, $fields['report_level_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Type:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-3">
				{!! Form::select('report_type_id', $report_types, $fields['report_type_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
			
			<div class="col-lg-7">
				<div class="form-group">
					<div class="input-group date" id="start_at">
						{!! Form::text('start_date', $fields['start_date'], ['class' => 'form-control']) !!}
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>
				@if ($fields['report_type_id'] == \Dodona\ReportType::CUSTOM)
				<div class="form-group">
					<div class="input-group date" id="end_at">
						{!! Form::text('end_date', $fields['end_date'], ['class' => 'form-control']) !!}
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>
				<script type="text/javascript">
					$(function () {
						$('#start_at').datetimepicker({
							viewMode: "{{ $fields['view_mode'] }}",
							format:   "{{ $fields['format'] }}",
							locale:   "en",
						})
						$('#end_at').datetimepicker({
							viewMode: "{{ $fields['view_mode'] }}",
							format:   "{{ $fields['format'] }}",
							locale:   "en",
						});
						$('#start_at').on("dp.change", function (e) {
							$('#end_at').data("DateTimePicker").minDate(e.date);
						});
						$('#end_at').on("dp.change", function (e) {
							$('#start_at').data("DateTimePicker").maxDate(e.date);
						});
					});
				</script>
				@else
				<script type="text/javascript">
					$(function () {
						$('#start_at').datetimepicker({
							viewMode: "{{ $fields['view_mode'] }}",
							format:   "{{ $fields['format'] }}",
							locale:   "en",
						})
					});
				</script>
				@endif
			</div>
		</div>
	
	{!! Form::close() !!}
	</div>
@stop