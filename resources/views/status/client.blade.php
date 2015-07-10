@extends('layouts.default')

@section('content')
	<h2>Client Current Status</h2>
	
	@include('includes.breadcrumb')
	
	<p>The current status of the <strong>{{ $client->name }}</strong> client per
		service and monitored area (Capacity, Recoverability, Availability, and
		Performance) is depicted here using RAG statuses.</p>
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th colspan="6">{{ $client->name }} ({{ $client->id }})</th>
			</tr>
			<tr>
				<th class="col-lg-3 text-center">Service</th>
				<th class="col-lg-2 text-center">Capacity</th>
				<th class="col-lg-2 text-center">Recoverability</th>
				<th class="col-lg-2 text-center">Availability</th>
				<th class="col-lg-2 text-center">Performance</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		
		<tbody>
		@forelse($client->enabledServices() as $service)
			<tr>
				<td class="col-lg-3">
                    @if ($service->refreshed()['manual'] > 0)
                    <span class="fa fa-book"></span>
                    @endif
                    @if ($service->refreshed()['auto'] > 0)
                    <span class="fa fa-spin fa-cog"></span>
                    @endif
                    {{ $client->name }} - {{ $service->name }} ({{ $service->id }})
                </td>
				<td class="col-lg-2 alert alert-{{ $service->capacityStatus()->css }} text-center text-capitalize">{{ $service->capacityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $service->recoverabilityStatus()->css }} text-center text-capitalize">{{ $service->recoverabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $service->availabilityStatus()->css }} text-center text-capitalize">{{ $service->availabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $service->performanceStatus()->css }} text-center text-capitalize">{{ $service->performanceStatus()->name }}</td>
				<td class="col-lg-1 text-center">
					<a href="{{ url("/status/service/{$service->id}") }}" class="btn btn-primary btn-xs btn-block">
						<span class="fa fa-sitemap"></span>&nbsp;Details
					</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="6" class="alert alert-info text-center">No active services found for this client.</td>
			</tr>
		@endforelse
		</tbody>
	</table>
@stop