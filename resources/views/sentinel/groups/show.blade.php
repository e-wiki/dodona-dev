@extends('layouts.default')

@section('content')
<h2>{{ $group['name'] }} Group</h2>
	<div class="col-lg-5">
        <label class="col-lg-3">Permissions:</label>
        <ul class="list-group col-lg-9">
	    	@foreach ($group->getPermissions() as $key => $value)
            <li class="list-group-item">{{ ucfirst($key) }}</li>
	    	@endforeach
	    </ul>
	</div>
	<div class="col-lg-offset-5 col-lg-2">
		<a class="btn btn-primary btn-block" href="{{ route('sentinel.groups.edit', array($group->hash)) }}">Edit Group</a>
	</div> 

@stop
