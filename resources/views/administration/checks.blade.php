@extends('layouts.default')

@section('content')
	<h2>Check Management Console</h2>
	
	@include('includes.breadcrumb')
	
	<p>Actions will take effect immediately. Please note that no data will be
		deleted at any point.</p>
	
	@include('flash::message')
	
	<table class="table table-responsive">
		<thead>
			<tr>
				<th class="col-lg-6 text-center">Check</th>
				<th class="col-lg-1 text-center">ID</th>
				<th class="col-lg-1 text-center">Check Category</th>
				<th class="col-lg-3 text-center">Check Module</th>
				<th class="col-lg-1" />
			</tr>
		</thead>
		<tbody>
			@forelse ($checks as $check)
			<tr>
				<td class="col-lg-6">{{ $check->name }}</td>
				<td class="col-lg-1 text-center">{{ $check->id }}</td>
				<td class="col-lg-1 text-center">{{ $check->checkCategory->name }}</td>
				<td class="col-lg-3">{{ $check->checkModule->name }}</td>
				<td class="col-lg-1" />
			</tr>
			@empty
			<tr class="alert alert-info">
				<td colspan="5" class="col-lg-12 text-center">No checks identified.</td>
			</tr>
			@endforelse
			{!! Form::open(['action' => 'Administration\CheckController@store', 'class' => 'form-horizontal']) !!}
			<tr>
				<td class="col-lg-6">
					<div  class="form-group {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('name', NULL, ['class' => 'form-control', 'maxlength' => 100, 'placeholder' => 'Check']) !!}
						@if ($errors->first('name'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-1">
					<div  class="form-group {{ $errors->first('id') ? 'has-error has-feedback' : '' }}">
						{!! Form::text('id', NULL, ['class' => 'form-control', 'maxlength' => 6, 'placeholder' => 'XXX000']) !!}
						@if ($errors->first('id'))
						<span class="form-control-feedback glyphicon glyphicon-alert"></span>
						@endif
					</div>
				</td>
				<td class="col-lg-3">{!! Form::select('check_category_id', $check_categories_list, Input::old('check-category_id'), ['class' => 'form-control']) !!}</td>
				<td class="col-lg-3">{!! Form::select('check_module_id', $check_modules_list, Input::old('check_module_id'), ['class' => 'form-control']) !!}</td>
				<td colspan="1" class="col-lg-2">{!! Form::submit('Add Check', ['class' => 'btn btn-primary btn-block']) !!}</td>
			</tr>
			{!! Form::close() !!}
		</tbody>
	</table>

    {!! $checks->render() !!}
  @stop