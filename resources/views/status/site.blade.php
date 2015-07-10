@extends('layouts.default')

@section('content')
	<h2>Site Current Status</h2>
	
	@include('includes.breadcrumb')
	
	<p>The current status of the <strong>{{ $client->name }}
		{{ $service->name }} {{ $site->name }} ({{ $site->id }})</strong>
        site per server and monitored area (Capacity, Recoverability,
        Availability, and Performance) is depicted here using RAG statuses. The
        date/time presented is when the checks were performed.</p>
	
	<table class="table table-responsive">
		<thead>
            <th class="col-lg-3">{{ $site->name }} ({{ $site->id }})</th>
            <th class="col-lg-2 text-center">Capacity</th>
            <th class="col-lg-2 text-center">Recoverability</th>
            <th class="col-lg-2 text-center">Availability</th>
            <th class="col-lg-2 text-center">Performance</th>
            <th class="col-lg-1" />
		</thead>
		
		<tbody>
		@forelse($site->enabledServers() as $server)
			<tr>
				<td class="col-lg-3">
                    <span class="fa {{ ($server->auto_refreshed) ? 'fa-spin fa-cog' : 'fa-book' }}"></span>
                    {{ $server->name }} ({{ $server->id }})
                </td>
				<td class="col-lg-2 alert alert-{{ $server->capacityStatus()->css }} text-center text-capitalize">{{ $server->capacityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->recoverabilityStatus()->css }} text-center text-capitalize">{{ $server->recoverabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->availabilityStatus()->css }} text-center text-capitalize">{{ $server->availabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $server->performanceStatus()->css }} text-center text-capitalize">{{ $server->performanceStatus()->name }}</td>
				<td class="col-lg-1 text-center">
					<a href="{{ url("status/server/{$server->id}") }}" class="btn btn-primary btn-xs btn-block">
						<span class="fa fa-server"></span>&nbsp;Details
					</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="6" class="alert alert-info text-center">No active servers found for this site.</td>
			</tr>
		@endforelse
		</tbody>
	</table>
@stop