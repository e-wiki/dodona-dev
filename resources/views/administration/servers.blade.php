@extends('layouts.default')

@section('content')
	<h2>Site Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-2 text-center">Server</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-1 text-center">Enabled</th>
				<th class="col-lg-2 text-center">Service</th>
				<th class="col-lg-2 text-center">OS</th>
				<th class="col-lg-2 text-center">DB Tech</th>
				<th class="col-lg-1 text-center">Site</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($servers as $server)
			<tr>
				<td class="col-lg-2">{{ $server->name }}</td>
				<td class="col-lg-1 text-center">{{ $server->id }}</td>
				<td class="col-lg-1 text-center">
					@if ($server->isEnabled())
					<span class="fa fa-check-circle-o text-success"></span>
					@else
					<span class="fa fa-circle-o text-danger"></span>
					@endif
				</td>
				<td class="col-lg-2">{{ $server->service()->name }}</td>
				<td class="col-lg-2">{{ $server->operatingSystem->name }}</td>
				<td class="col-lg-2">{{ $server->databaseTechnology->name }}</td>
				<td class="col-lg-1">{{ $server->site->name }}</td>
				<td class="col-lg-1">
					@if ($server->isEnabled())
					<a href="{{ url("administration/server/disable/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Disable</a>
					@else
					<a href="{{ url("administration/server/enable/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Enable</a>
					@endif
				</td>
			</tr>
			@empty
			<tr class="alert alert-info">
				<th colspan="8" class="col-lg-12 text-center">No sites identified.</th>
			</tr>
			@endforelse
			{!! Form::open(['url' => '/server/store/', 'class' => 'form-horizontal']) !!}
			<tr>
				<td class="col-lg-2">
					<div  class="form-group {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('name', NULL, ['class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Service Name']) !!}
						@if ($errors->first('name'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1">
					<div  class="form-group {{ $errors->first('id') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('id', NULL, ['class' => 'form-control', 'maxlength' => 10, 'placeholder' => 'XX000Y0000']) !!}
						@if ($errors->first('id'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1 text-center">{!! Form::checkbox('enabled', 1, FALSE) !!}</td>
				<td class="col-lg-2">{!! Form::select('service_id', $service_list, Input::old('service_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-2">{!! Form::select('operating_system_id', $operating_system_list, Input::old('operating_system_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-2">{!! Form::select('database_technology_id', $database_technology_list, Input::old('database_technology_id'), ['class' => 'form-control']) !!}</td>
				<td colspan="2" class="col-lg-2">{!! Form::select('site_id', $site_list, Input::old('site_id'), ['class' => 'form-control']) !!}</td>
			</tr>
			<tr>
				<td colspan="7" class="col-lg-11">
					<div  class="form-group {{ $errors->first('description') ? 'has-error has-feedback' : '' }}">
						{!! Form::textarea('description', NULL, ['class' => 'form-control', 'cols' => 40, 'rows' => '1', 'placeholder' => 'Description']) !!}
						@if ($errors->first('description'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1">{!! Form::submit('Add Server', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>
  @stop