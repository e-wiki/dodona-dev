@extends('layouts.default')

@section('content')
	<h2>Service Current Status</h2>
	
	@include('includes.breadcrumb')
	
	<p>The current status of the <strong>{{ $service->client->name }}
		{{ $service->name }} ({{ $service->id }})</strong> service per server
		and monitored area (Capacity, Recoverability, Availability, and
		Performance) is depicted here using RAG statuses. The date/time
		presented is when the checks were performed.</p>
	
	<table class="table table-responsive">
		<thead>
            <th class="col-lg-3">{{ $service->name }} ({{ $service->id }})</th>
            <th class="col-lg-2 text-center">Capacity</th>
            <th class="col-lg-2 text-center">Recoverability</th>
            <th class="col-lg-2 text-center">Availability</th>
            <th class="col-lg-2 text-center">Performance</th>
            <th class="col-lg-1" />
		</thead>
		
		<tbody>
		@forelse($service->enabledServers() as $server)
			<tr>
				<td class="col-lg-3">{{ $server->name }} ({{ $server->id }})</td>
				<td class="col-lg-2 alert alert-{{ $server->capacityStatus()->css }} text-center text-capitalize">{{ $server->capacityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->recoverabilityStatus()->css }} text-center text-capitalize">{{ $server->recoverabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->availabilityStatus()->css }} text-center text-capitalize">{{ $server->availabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->performanceStatus()->css }} text-center text-capitalize">{{ $server->performanceStatus()->name }}</td>
				<td class="col-lg-1 text-center">
					<a href="{{ url("status/server/{$server->id}") }}" class="btn btn-primary btn-xs">
						<span class="fa fa-server"></span>&nbsp;Details
					</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="6" class="alert alert-info text-center">No active servers found for this service.</td>
			</tr>
		@endforelse
		</tbody>
	</table>
@stop