@extends('layouts.default')

@section('content')
	<h2>Client Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-2 text-center">Client</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-1 text-center">Enabled</th>
				<th class="col-lg-6 text-center">Comments</th>
				<th class="col-lg-1 text-center"># of Services</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($clients as $client)
			<tr>
				<td class="col-lg-2">{{ $client->name }}</td>
				<td class="col-lg-1 text-center">{{ $client->id }}</td>
				<td class="col-lg-1 text-center">
					@if ($client->isEnabled())
					<span class="fa fa-check-circle-o text-success"></span>
					@else
					<span class="fa fa-circle-o text-danger"></span>
					@endif
				</td>
				<td class="col-lg-6">{{ $client->description }}</td>
				<td class="col-lg-1 text-center">{{ $client->services()->count() }}</td>
				<td class="col-lg-1">
					@if ($client->isEnabled())
					<a href="{{ url("administration/client/disable/{$client->id}") }}" class="btn btn-primary btn-block btn-xs">Disable</a>
					@else
					<a href="{{ url("administration/client/enable/{$client->id}") }}" class="btn btn-primary btn-block btn-xs">Enable</a>
					@endif
				</td>
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="6" class="col-lg-12 text-center">No clients identified.</td>
			</tr>
			@endforelse
		</tbody>
	</table>
  @stop