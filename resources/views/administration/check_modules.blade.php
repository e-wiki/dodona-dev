@extends('layouts.default')

@section('content')
	<h2>Check Module Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	@include('flash::message')
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-3 text-center">Check Module</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-1 text-center"># of Checks</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($check_modules as $check_module)
			<tr>
				<td class="col-lg-3">{{ $check_module->name }}</td>
				<td class="col-lg-1 text-center">{{ $check_module->id }}</td>
                <td class="col-lg-1 text-center">{{ $check_module->checks->count() }}</td>
				<td class="col-lg-1" />
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="4" class="col-lg-12 text-center">No check modules identified.</td>
			</tr>
			@endforelse
			{!! Form::open(['action' => 'Administration\CheckModuleController@store', 'class' => 'form-horizontal']) !!}
			<tr>
				<td colspan="3" class="col-lg-5">
					<div  class="form-group {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('name', NULL, ['class' => 'form-control', 'maxlength' => 50, 'placeholder' => 'Check Module']) !!}
						@if ($errors->first('name'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td colspan="1" class="col-lg-2">{!! Form::submit('Add Check Module', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>

    {!! $check_modules->render() !!}
  @stop