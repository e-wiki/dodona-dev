@extends('layouts.default')

@section('content')
	<h2>Clients Current Status</h2>
	
	<p>The current status for each monitored service per client and monitored
		area (Capacity, Recoverability, Availability, and Performance) is
		depicted here using RAG statuses. The date/time presented is when the
		checks were performed.</p>
	
	<table class="table table-responsive">
		<thead>
            <th class="col-lg-3">Client</th>
            <th class="col-lg-2 text-center">Capacity</th>
            <th class="col-lg-2 text-center">Recoverability</th>
            <th class="col-lg-2 text-center">Availability</th>
            <th class="col-lg-2 text-center">Performance</th>
            <th class="col-lg-1" />
		</thead>
		
		<tbody>
		@forelse($clients as $client)
			<tr>
				<td class="col-lg-3">{{ $client->name }} ({{ $client->id }})</td>
				<td class="col-lg-2 alert alert-{{ $client->capacityStatus()->css }} text-center text-capitalize">{{ $client->capacityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $client->recoverabilityStatus()->css }} text-center text-capitalize">{{ $client->recoverabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $client->availabilityStatus()->css }} text-center text-capitalize">{{ $client->availabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $client->performanceStatus()->css }} text-center text-capitalize">{{ $client->performanceStatus()->name }}</td>
				<td class="col-lg-1 text-center">
					<a href="{{ url("/status/client/{$client->id}") }}" class="btn btn-primary btn-xs">
						<span class="fa fa-cogs"></span>&nbsp;Details
					</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="6" class="alert alert-info text-center">No active clients found.</td>
			</tr>
		@endforelse
		</tbody>
	</table>
@stop