@extends('layouts.default')

@section('content')
	<h2>Raise Ticket</h2>
	
	@include('includes.breadcrumb')
	
	<p>Complete the form and send the ticket information to the Service Desk
		mailbox.</p>
	
	<p>Internal Reference number will be created once the information is
		completed and submitted.</p>
	
	<div class="col-lg-6">
	{!! Form::open(['action' => 'TicketController@store', 'class' => 'form-horizontal']) !!}
		<h3>Required Details</h3>
		
		{!! Form::hidden('server_id', $server->id) !!}
		
		@if(is_null($server_check_result->serverCheckResult))
		{!! Form::hidden('server_check_result_id', $server_check_result->id) !!}
		@else
		{!! Form::hidden('server_check_result_id', $server_check_result->serverCheckResult->id) !!}
		@endif
		
		<div class="form-group" >
			{!! Form::label('', 'User:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10" >
				{!! Form::select('user_id', $users, Input::old('id'), ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Category:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::select('ticket_category_id', $ticket_categories, Input::old('id'), ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Type:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::select('ticket_type_id', $ticket_types, Input::old('id'), ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Priority:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::select('ticket_priority_id', $ticket_priorities, $ticket_priority, ['class' => 'form-control']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Reference:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::hidden('reference', $reference) !!}
				{!! Form::text('reference', $reference, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Summary:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				{!! Form::hidden('summary', $server_check_result->checkResult->name . '.') !!}
				{!! Form::textarea('summary', $server_check_result->checkResult->name . '.', ['class' => 'form-control', 'rows' => 2, 'disabled' => 'disabled', 'style' => 'resize: none;']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('', 'Description:', ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-10">
				@if ($errors->any())
					@foreach ($errors->all() as $error)
					<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
				@endif
				{!! Form::textarea('description', 'Error occurred at: ' . $server_check_result->raised_at . '. ' . $server_check_result->checkResult->name . '.', ['class' => 'form-control', 'rows' => 6, 'style' => 'resize: none;']) !!}
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label(NULL, NULL, ['class' => 'col-lg-2 control-label']) !!}
			<div class="col-lg-5">
				{!! Form::submit('Create', ['value' => 'store', 'class' => 'btn btn-primary btn-block']) !!}
			</div>
			<div class="col-lg-5">
                {!! HTML::linkAction('TicketController@create', 'Reset', [$server_check_result->id], ['class' => 'btn btn-primary btn-block']) !!}
			</div>
		</div>
	{!! Form::close() !!}
	</div>
@stop