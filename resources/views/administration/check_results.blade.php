@extends('layouts.default')

@section('content')
	<h2>Check Result Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	@include('flash::message')
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-6 text-center">Check Result</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-3 text-center">Check </th>
				<th class="col-lg-1 text-center">Alert</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($check_results as $check_result)
			<tr>
				<td class="col-lg-6">{{ $check_result->name }}</td>
				<td class="col-lg-1 text-center">{{ $check_result->id }}</td>
				<td class="col-lg-3 text-center">{{ $check_result->check->name }} ({{ $check_result->check->id }})</td>
				<td class="col-lg-1 alert alert-{{ $check_result->alert->css }} text-center text-capitalize">{{ $check_result->alert->name }}</td>
				<td class="col-lg-1" />
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="5" class="col-lg-12 text-center">No check results identified.</td>
			</tr>
			@endforelse
			{!! Form::open(['action' => 'Administration\CheckResultController@store', 'class' => 'form-horizontal']) !!}
			<tr>
				<td class="col-lg-6">
					<div  class="form-group {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('name', NULL, ['class' => 'form-control', 'maxlength' => 100, 'placeholder' => 'Check Result']) !!}
						@if ($errors->first('name'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1">
					<div  class="form-group {{ $errors->first('id') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('id', NULL, ['class' => 'form-control', 'maxlength' => 9, 'placeholder' => 'XXX000Y00']) !!}
						@if ($errors->first('id'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-3">{!! Form::select('check_id', $checks_list, Input::old('check_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-1">{!! Form::select('alert_id', $alerts_list, Input::old('alert_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-1">{!! Form::submit('Add Check Result', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>

    {!! $check_results->render() !!}
  @stop