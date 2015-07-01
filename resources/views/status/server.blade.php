@extends('layouts.default')

@section('content')
	<h2>Server Current Status</h2>
	
	@include('includes.breadcrumb')
	
	<p>The current status of the <strong>{{ $service->client->name }}
		{{ $service->name }} {{ $server->name }} ({{ $server->id }})</strong>
		server per monitored area (Capacity, Recoverability, Availability, and
		Performance) and individual checks is depicted here using RAG statuses.
		The date/time presented is when the checks were performed (and not when
		the healthcheck was introduced in the system).</p>
	
	@include('flash::message')
	
	<table class="table table-responsive">
		<thead>
            <th class="col-lg-3">Check</th>
            <th class="col-lg-1">Result</th>
            <th class="col-lg-5">Message</th>
            <th class="col-lg-2">DateTime</th>
            <th class="col-lg-1" />
		</thead>
		
		<tbody>
		@foreach($check_categories as $check_category)
			<tr>
				<th colspan="5">{{ $check_category->name }}</th>
			</tr>
			@forelse($checks as $check)
				@if($check->check->checkCategory->id === $check_category->id)
			<tr class="alert alert-{{ $check->checkResult->alert->css_i }}">
				<td class="col-lg-3">{{ $check->check->name }} ({{ $check->check->id }})</td>
				<td class="col-lg-1 text-capitalize">{{ $check->checkResult->id }}</td>
				<td class="col-lg-5">{{ $check->checkResult->name }}</td>
				<td class="col-lg-2">{{ $check->raised_at }}</td>
				<td class="col-lg-1 ">
					@if($check->checkResult->alert_id === \Dodona\Alert::AMBER or $check->checkResult->alert_id === \Dodona\Alert::RED)
						@if(empty($check->ticket_id))
						<a href="{{ action('TicketController@create', [$check->id]) }}" class="btn btn-primary btn-xs btn-block"><span class="fa fa-ticket"></span>&nbsp;Create Ticket</a>
						@else
						<a href="{{ action('TicketController@show', [$check->ticket_id]) }}" class="btn btn-default btn-xs btn-block"><span class="fa fa-ticket"></span>&nbsp;Show Ticket</a>
						@endif
					@endif
				</td>
			</tr>
				@endif
			@empty
			<tr>
				<td colspan="5" class="alert alert-info text-center">No active {{ $check_category->name }} checks found for this server.</td>
			</tr>
			@endforelse
		@endforeach
		</tbody>
	</table>
@stop