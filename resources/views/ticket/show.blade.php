@extends('layouts.default')

@section('content')
	<h2>Show Ticket</h2>
	
	@include('includes.breadcrumb')
	
	<p>This is the information sent to the Service Desk for the
		<strong>#&nbsp;{{ $server_check_result->id }}</strong> incident
		with reference <strong>{{ $ticket->reference }}</strong>.</p>
	
	<div class="col-lg-6">
		<h3>Ticket Raised</h3>
		
	    <pre class="alert alert-info">
Contact Details
Service Name: {{ $service->client->name }} {{ $service->name }}
User:         {{ $ticket->user->full_name }} &lt;{{ $ticket->user->email }}&gt;
&NewLine;
Configuration Item Details
Service Name: {{ $service->name }}
Item Name:    {{ $server->name }}
Category:     {{ $ticket->ticketCategory->name }}
&NewLine;
Incident Details
Type:         {{ $ticket->ticketType->name }}
Priority:     {{ $ticket->ticketPriority->name }}
Reference:    {{ $ticket->reference }}
Source:       email
Summary:      {{ $ticket->summary }}
Description:  {{ $ticket->description }}
	    </pre>
	</div>
	
	<div class="col-lg-6">
		<h3>Notes</h3>

		<ul class="list-group">
			<li class="list-group-item">The information is true from the moment
				it was submitted.</li>
			<li class="list-group-item">An email was sent to the Service Desk,
				but may not have reached the mailbox yet.</li>
			<li class="list-group-item">A ticket may have not yet been raised in
				<a href="http://ukdc1csudcsv01.csu.local/Sostenuto/SUsers/" class="btn btn-primary btn-xs" target="_blank">Sostenuto Sunrise&nbsp;<span class="fa fa-external-link-square"></span></a>
				.</li>
		</ul>
	</div>
@stop