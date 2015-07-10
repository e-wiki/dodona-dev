@extends('layouts.default')

@section('content')
	<h2>Service Current Status</h2>
	
	@include('includes.breadcrumb')
	
	<p>The current status of the <strong>{{ $service->client->name }}
		{{ $service->name }} ({{ $service->id }})</strong> service per site
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
		@forelse($service->enabledSites() as $site)
			<tr>
				<td class="col-lg-3">
                    @if ($site->refreshed()['manual'] > 0)
                    <span class="fa fa-book"></span>
                    @endif
                    @if ($site->refreshed()['auto'] > 0)
                    <span class="fa fa-spin fa-cog"></span>
                    @endif
                    {{ $site->name }} ({{ $site->id }})
                </td>
				<td class="col-lg-2 alert alert-{{ $site->capacityStatus()->css }} text-center text-capitalize">{{ $site->capacityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $site->recoverabilityStatus()->css }} text-center text-capitalize">{{ $site->recoverabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $site->availabilityStatus()->css }} text-center text-capitalize">{{ $site->availabilityStatus()->name }}</td>
				<td class="col-lg-2 alert alert-{{ $site->performanceStatus()->css }} text-center text-capitalize">{{ $site->performanceStatus()->name }}</td>
				<td class="col-lg-1 text-center">
					<a href="{{ url("status/site/{$site->id}") }}" class="btn btn-primary btn-xs btn-block">
						<span class="fa fa-building-o"></span>&nbsp;Details
					</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="6" class="alert alert-info text-center">No sites found for this service.</td>
			</tr>
		@endforelse
		</tbody>
	</table>
@stop