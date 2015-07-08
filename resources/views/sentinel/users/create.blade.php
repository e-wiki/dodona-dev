@extends('layouts.default')

@section('content')
    <div class="col-lg-12">
        <form method="POST" action="{{ route('sentinel.users.store') }}" class="form-horizontal" accept-charset="UTF-8">

            <h2>Create New User</h2>

            <div class="form-group">
                {!! Form::label(NULL, 'Username:', ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5 {{ $errors->first('username') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Username" name="username" type="text"  value="{{ Input::old('username') }}">
                    @if ($errors->first('username'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, 'Email:', ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5 {{ $errors->first('email') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="E-mail" name="email" type="text"  value="{{ Input::old('email') }}">
                    @if ($errors->first('email'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, 'Password:', ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5 {{ $errors->first('password') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Password" name="password" value="" type="password">
                    @if ($errors->first('password'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, 'Confirm:', ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5 {{ $errors->first('password_confirmation') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" type="password">
                    @if ($errors->first('password_confirmation'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-5">
                    <label class="checkbox-inline">
                        <input name="activate" value="activate" type="checkbox"> Activate
                    </label>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-2">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary btn-block" value="Create" type="submit">
                </div>
            </div>

        </form>
    </div>


@stop