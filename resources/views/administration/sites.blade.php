@extends('layouts.default')

@section('content')
	<h2>Site Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-3 text-center">Site</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-3 text-center">Service (ID)</th>
				<th class="col-lg-2 text-center">Environment</th>
				<th class="col-lg-1 text-center"># of Servers</th>
				<th class="col-lg-2" />
			</tr>
		</thead>
		<tbody>
			@forelse ($sites as $site)
			<tr>
				<td class="col-lg-3">{{ $site->name }}</td>
				<td class="col-lg-1 text-center">{{ $site->id }}</td>
				<td class="col-lg-3">{{ $site->service->name }} ({{ $site->service->id }})</td>
				<td class="col-lg-2 text-center">{{ $site->environment->name }} ({{ $site->environment->id }})</td>
				<td class="col-lg-1 text-center">{{ $site->servers()->count() }}</td>
				<td class="col-lg-2" />
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="6" class="col-lg-12 text-center">No sites identified.</td>
			</tr>
			@endforelse
			{!! Form::open(['url' => '/site/store/', 'class' => 'form-horizontal']) !!}
			<tr>
				<td class="col-lg-3">
					<div  class="form-group {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('name', NULL, ['class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Site Name']) !!}
						@if ($errors->first('name'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1">
					<div  class="form-group {{ $errors->first('id') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('id', NULL, ['class' => 'form-control', 'maxlength' => 7, 'placeholder' => 'XX000Y0']) !!}
						@if ($errors->first('id'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-3">{!! Form::select('service_id', $service_list, Input::old('service_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-2">{!! Form::select('environment_id', $environment_list, Input::old('environment_id'), ['class' => 'form-control']) !!}</td>
				<td colspan="2" class="col-lg-2">{!! Form::submit('Add Site', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>
  @stop