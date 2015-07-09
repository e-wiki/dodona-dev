@extends('layouts.default')

@section('content')
    <h2>Create New Group</h2>

	@include('includes.breadcrumb')

    <div class="col-lg-12">
        <form method="POST" action="{{ route('sentinel.groups.store') }}" class="form-horizontal" accept-charset="UTF-8">
            <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
                {!! Form::label(NULL, 'Name', ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5 {{ $errors->first('name') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Group Name" name="name" type="text">
                    @if ($errors->first('name'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Permissions', 'Permissions', ['class' => 'col-lg-1 control-label']) !!}
                <div class="form-group">
                    <?php $defaultPermissions = config('sentinel.default_permissions', []); ?>
                    <div class="col-lg-5">
                    @foreach ($defaultPermissions as $permission)
                        <label class="checkbox-inline">
                            <input name="permissions[{{ $permission }}]" value="1" type="checkbox"
                            @if (Input::old('permissions[' . $permission .']'))
                               checked
                            @endif
                            > {{ ucwords($permission) }}
                        </label>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-2">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary btn-block" value="Create New Group" type="submit">
                </div>
                <div class="col-lg-2">
                    <a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}" class="btn btn-primary btn-block">Cancel</a>
                </div>
            </div>

        </form>

    </div>

@stop