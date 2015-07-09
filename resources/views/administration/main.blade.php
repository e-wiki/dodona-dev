@extends('layouts.default')

@section('content')
	<h2>Administration</h2>
	
	<p>Choose an option from the following to manage the specific items.</p>
	
	<div class="list-group col-lg-4">
		<a href="{{ url('administration/clients') }}" class="list-group-item">Manage Clients<span class="badge badge-info">{{ $clients_count }}</span></a>
		<a href="{{ url('administration/services') }}" class="list-group-item">Manage Services<span class="badge badge-info">{{ $services_count }}</span></a>
		<a href="{{ url('administration/sites') }}" class="list-group-item">Manage Sites<span class="badge badge-info">{{ $sites_count }}</span></a>
		<a href="{{ url('administration/servers') }}" class="list-group-item">Manage Servers<span class="badge badge-info">{{ $servers_count }}</span></a>
	</div>
	
	<div class="list-group col-lg-4">
		<a href="{{ url('administration/check_modules') }}" class="list-group-item">Manage Check Modules<span class="badge badge-info">{{ $check_modules_count }}</span></a>
		<a href="{{ url('administration/checks') }}" class="list-group-item">Manage Checks<span class="badge badge-info">{{ $checks_count }}</span></a>
		<a href="{{ url('administration/check_results') }}" class="list-group-item">Manage Check Results<span class="badge badge-info">{{ $check_results_count }}</span></a>
	</div>
	
	<div class="list-group col-lg-4">
		<a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}" class="list-group-item">Manage Groups<span class="badge badge-info">{{ $groups_count }}</span></a>
		<a href="{{ action('\\Sentinel\Controllers\UserController@index') }}" class="list-group-item">Manage Users<span class="badge badge-info">{{ $users_count }}</span></a>
	</div>
@stop