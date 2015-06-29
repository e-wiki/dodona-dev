@extends('layouts.default')

@section('content')
	<h2>Service Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	<table class="table table-responsive">
		<thead>
        <tr>
            <th class="col-lg-2 text-center">Service</th>
            <th class="col-lg-1 text-center">ID</th>
            <th class="col-lg-5 text-center">Client ID</th>
            <th class="col-lg-1 text-center">Enabled</th>
            <th class="col-lg-1 text-center"># of Sites</th>
            <th class="col-lg-1 text-center"># of Servers</th>
            <th class="col-lg-1" />
        </tr>
		</thead>
		<tbody>
			@forelse ($services as $service)
			<tr>
				<td class="col-lg-2">{{ $service->name }}</td>
				<td class="col-lg-1 text-center">{{ $service->id }}</td>
				<td class="col-lg-5">{{ $service->client->name }} ({{ $service->client->id }})</td>
				<td class="col-lg-1 text-center">
					@if ($service->isEnabled())
					<span class="fa fa-check-circle-o text-success"></span>
					@else
					<span class="fa fa-circle-o text-danger"></span>
					@endif
				</td>
				<td class="col-lg-1 text-center">{{ $service->sites()->count() }}</td>
				<td class="col-lg-1 text-center">{{ $service->servers()->count() }}</td>
				<td class="col-lg-1">
					@if ($service->isEnabled())
					<a href="{{ url("administration/service/disable/{$service->id}") }}" class="btn btn-primary btn-block btn-xs">Disable</a>
					@else
					<a href="{{ url("administration/service/enable/{$service->id}") }}" class="btn btn-primary btn-block btn-xs">Enable</a>
					@endif
				</td>
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="6" class="col-lg-12 text-center">No services identified.</td>
			</tr>
			@endforelse
		</tbody>
	</table>
  @stop