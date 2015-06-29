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
				<th class="col-lg-2 text-center">Service</th>
				<th class="col-lg-2 text-center">OS</th>
				<th class="col-lg-2 text-center">DB Tech</th>
				<th class="col-lg-1 text-center">Site</th>
				<th class="col-lg-1 text-center">Enabled</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($servers as $server)
			<tr>
				<td class="col-lg-2">{{ $server->name }}</td>
				<td class="col-lg-1 text-center">{{ $server->id }}</td>
				<td class="col-lg-2">{{ $server->service()->name }}</td>
				<td class="col-lg-2">{{ $server->operatingSystem->name }}</td>
				<td class="col-lg-2">{{ $server->databaseTechnology->name }}</td>
				<td class="col-lg-1">{{ $server->site->name }}</td>
				<td class="col-lg-1 text-center">
					@if ($server->isEnabled())
					<span class="fa fa-check-circle-o text-success"></span>
					@else
					<span class="fa fa-circle-o text-danger"></span>
					@endif
				</td>
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
				<td colspan="6" class="col-lg-12 text-center">No sites identified.</td>
			</tr>
			@endforelse
		</tbody>
	</table>
  @stop