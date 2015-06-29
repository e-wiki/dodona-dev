@extends('layouts.default')

@section('content')
	<h2>Site Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-3 text-center">Site</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-4 text-center">Service (ID)</th>
				<th class="col-lg-3 text-center">Environment</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($sites as $site)
			<tr>
				<td class="col-lg-3">{{ $site->name }}</td>
				<td class="col-lg-1 text-center">{{ $site->id }}</td>
				<td class="col-lg-4">{{ $site->service->name }} ({{ $site->service->id }})</td>
				<td class="col-lg-3 text-center">{{ $site->environment->name }} ({{ $site->environment->id }})</td>
				<td class="col-lg-1" />
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="6" class="col-lg-12 text-center">No sites identified.</td>
			</tr>
			@endforelse
		</tbody>
	</table>
  @stop