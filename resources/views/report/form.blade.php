@extends('layouts.default')

@section('content')
	<h2>Report Creation</h2>
	
	<p>Create a report based on the choices below.</p>

    <br>

	<div class="col-lg-6">
	{!! Form::open(['class' => 'form-horizontal', 'url' => '/report/']) !!}
    
        @if ($choices['client_id'])
        {!! Form::hidden('current_client_id', $choices['client_id']) !!}
        @endif
        @if ($choices['service_id'])
        {!! Form::hidden('current_service_id', $choices['service_id']) !!}
        @endif
        @if ($choices['site_id'])
        {!! Form::hidden('current_site_id', $choices['site_id']) !!}
        @endif
        @if ($choices['server_id'])
        {!! Form::hidden('current_server_id', $choices['server_id']) !!}
        @endif
		
		<div class="form-group">
			{!! Form::label('', 'Level:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-3">
				{!! Form::select('report_level_id', $report_levels, $choices['report_level_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
			<div class="col-lg-7">
				{!! Form::select('client_id', $client_list, $choices['client_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
		</div>

        @if ($choices['report_level_id'] > Dodona\Models\Reporting\ReportLevel::CLIENT_LEVEL_ID)
        <div class="form-group">
			<div class="col-lg-offset-5 col-lg-7">
				{!! Form::select('service_id', $service_list, $choices['service_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
        </div>
        @endif

        @if ($choices['report_level_id'] > Dodona\Models\Reporting\ReportLevel::SERVICE_LEVEL_ID)
        <div class="form-group">
			<div class="col-lg-offset-5 col-lg-7">
                {!! Form::select('site_id', $site_list, $choices['site_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
        </div>
        @endif

        @if ($choices['report_level_id'] > Dodona\Models\Reporting\ReportLevel::SITE_LEVEL_ID)
        <div class="form-group">
			<div class="col-lg-offset-5 col-lg-7">
				{!! Form::select('server_id', $server_list, $choices['server_id'], ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
			</div>
        </div>
        @endif

        <div class="form-group">
			{!! Form::label('', 'Range:', ['class' => 'col-lg-2 control-label']) !!}
        </div>

        <div class="form-group">
			<div class="col-lg-offset-2 col-lg-5">
				{!! Form::submit('Create Report', ['value' => 'store', 'class' => 'btn btn-primary btn-block']) !!}
			</div>
			<div class="col-lg-5">
                {!! HTML::link('#', 'Reset', ['class' => 'btn btn-primary btn-block']) !!}
			</div>
            </div>
        </div>
	
	{!! Form::close() !!}
	</div>
@stop