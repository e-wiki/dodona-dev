	<div class="btn-group btn-breadcrumb">
	@if (Request::segment(1) === 'status' or Request::segment(1) === 'ticket')
		<a href="{{ url('/') }}" class="btn btn-default"><span class="fa fa-home"></span></a>
		
		<a href="{{ url('/status/client/' . $client->id) }}" class="btn btn-default"><span class="fa fa-cogs"></span>&nbsp;{{ $client->name }}</a>
		
		@if (Request::segment(2) === 'service' or Request::segment(2) === 'server' or Request::segment(1) === 'ticket')
		<a href="{{ url('/status/service/' . $service->id) }}" class="btn btn-default"><span class="fa fa-sitemap"></span>&nbsp;{{ $service->name }}</a>
		@endif
		
		@if (Request::segment(2) === 'server' or Request::segment(1) === 'ticket')
		<a href="{{ url('/status/server/' . $server->id) }}" class="btn btn-default"><span class="fa fa-server"></span>&nbsp;{{ $server->name }}</a>
		@endif

		@if (Request::segment(1) === 'ticket' and Request::segment(2) === 'create')
		<a href="{{ url('ticket/create/' . $server_check_result->id) }}" class="btn btn-default"><span class="fa fa-ticket"></span>&nbsp;Raise Ticket</a>
		@endif

		@if (Request::segment(1) === 'ticket' and Request::segment(2) === 'show')
		<a href="{{ url('/ticket/show/' . $ticket->id) }}" class="btn btn-default"><span class="fa fa-ticket"></span>&nbsp;Show Ticket</a>
		@endif
	@endif
	
	@if (Request::segment(1) === 'administration')
		<a href="{{ url('/administration/') }}" class="btn btn-default"><span class="fa fa-home"></span></a>
		
		<a href="{{ url("administration/" . Request::segment(2)) }}" class="btn btn-default">{{ ucfirst(Request::segment(2)) }} Console</a>
	@endif
	</div>

	<br><br>