@extends('layouts.default')

@section('content')
	<h2>Administration</h2>
	
	<p>Choose an option from the following to manage the specific items.</p>
	
	<div class="list-group col-lg-4">
		<a href="#" class="list-group-item">Manage Clients<span class="badge badge-info">{{ $clients_count }}</span></a>
		<a href="#" class="list-group-item">Manage Services<span class="badge badge-info">{{ $services_count }}</span></a>
		<a href="#" class="list-group-item">Manage Sites<span class="badge badge-info">{{ $sites_count }}</span></a>
		<a href="#" class="list-group-item">Manage Servers<span class="badge badge-info">{{ $servers_count }}</span></a>
	</div>
	
	<div class="list-group col-lg-4">
		<a href="#" class="list-group-item">Manage Checks<span class="badge badge-info">{{ $checks_count }}</span></a>
		<a href="#" class="list-group-item">Manage Check Results<span class="badge badge-info">{{ $check_results_count }}</span></a>
	</div>
	
	<div class="list-group col-lg-4">
		<a href="#" class="list-group-item disabled">Manage Groups</a>
		<a href="#" class="list-group-item disabled">Manage Users</a>
	</div>
@stop