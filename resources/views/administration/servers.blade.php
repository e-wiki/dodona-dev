@extends('layouts.default')

@section('content')
	<h2>Site Management Console</h2>

	@include('includes.breadcrumb')

	<p>Actions will take effect immediately. Please note that no data will be
		removed from the database at any point.</p>

	@include('flash::message')

	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-2 text-center">Server</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-1 text-center">Enabled</th>
				<th class="col-lg-1 text-center">Service</th>
				<th class="col-lg-1 text-center">OS</th>
				<th class="col-lg-2 text-center">DB Tech</th>
				<th class="col-lg-1 text-center">Site</th>
				<th colspan="3" class="col-lg-3" />
			</tr>
		</thead>
		<tbody>
			@forelse ($servers as $server)
            <tr>
				<td class="col-lg-2 small">
                    <span class="fa {{ ($server->auto_refreshed) ? 'fa-spin fa-cog' : 'fa-book' }}"></span>
                    {{ $server->name }}
                </td>
				<td class="col-lg-1 text-center small">{{ $server->id }}</td>
				<td class="col-lg-1 text-center small">
					@if ($server->isEnabled())
					<span class="fa fa-check-circle-o text-success"></span>
					@else
					<span class="fa fa-circle-o text-danger"></span>
					@endif
				</td>
				<td class="col-lg-1 small">{{ $server->service()->name }}</td>
				<td class="col-lg-1 small">{{ $server->operatingSystem->name }}</td>
				<td class="col-lg-2 small">{{ $server->databaseTechnology->name }}</td>
				<td class="col-lg-1 small">{{ $server->site->name }}</td>
				<td class="col-lg-1">
                    @if ($server->isEnabled())
                    <a href="{{ url("server/disable/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Disable</a>
                    @else
                    <a href="{{ url("server/enable/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Enable</a>
                    @endif
                </td>
				<td class="col-lg-1">
                    @if ($server->isAutoRefreshed())
                    <a href="{{ url("server/manual/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Manual</a>
                    @else
                    <a href="{{ url("server/auto/{$server->id}") }}" class="btn btn-primary btn-block btn-xs">Auto</a>
                    @endif
				</td>
                <td class="col-lg-1">
                    <a href="#" class="btn btn-danger btn-block btn-xs disabled">Delete</a>
                </td>
			</tr>
			@empty
			<tr class="alert alert-info">
				<th colspan="10" class="col-lg-12 text-center">No sites identified.</th>
			</tr>
			@endforelse
        </tbody>
    </table>

    {!! $servers->render() !!}

    <h3>Add New Server</h3>

    <table>
        <tbody>
			{!! Form::open(['action' => 'Administration\ServerController@store', 'class' => 'form-horizontal']) !!}
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
				<td class="col-lg-1 text-center">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('enabled', 1, FALSE) !!} Enabled
                        </label>
                    </div>
                </td>
				<td class="col-lg-2">{!! Form::select('service_id', $service_list, Input::old('service_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-1">{!! Form::select('operating_system_id', $operating_system_list, Input::old('operating_system_id'), ['class' => 'form-control']) !!}</td>
                <td class="col-lg-2">{!! Form::select('database_technology_id', $database_technology_list, Input::old('database_technology_id'), ['class' => 'form-control']) !!}</td>
			</tr>
			<tr>
                <td class="col-lg-2">{!! Form::select('site_id', $site_list, Input::old('site_id'), ['class' => 'form-control']) !!}</td>
				<td colspan="4" class="col-lg-8">
					<div  class="form-group {{ $errors->first('description') ? 'has-error has-feedback' : '' }}">
						{!! Form::textarea('description', NULL, ['class' => 'form-control', 'cols' => 40, 'rows' => '1', 'placeholder' => 'Description']) !!}
						@if ($errors->first('description'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
                <td class="col-lg-2">{!! Form::submit('Add Server', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>
  @stop