@extends('layouts.default')

@section('content')
    <div class="col-md-4 col-md-offset-4">
        <form method="POST" action="{{ route('sentinel.register.user') }}" accept-charset="UTF-8" id="register-form">

            <h2>Register New Account</h2>

            <div class="form-group {{ ($errors->has('username')) ? 'has-error has-feedback' : '' }}">
                <input class="form-control" placeholder="Username" name="username" type="text" value="{{ Input::old('username') }}">
                @if ($errors->first('username'))
                <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error has-feedback' : '' }}">
                <input class="form-control" placeholder="E-mail" name="email" type="text" value="{{ Input::old('email') }}">
                @if ($errors->first('email'))
                <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error has-feedback' : '' }}">
                <input class="form-control" placeholder="Password" name="password" value="" type="password">
                @if ($errors->first('password'))
                <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error has-feedback' : '' }}">
                <input class="form-control" placeholder="Confirm Password" name="password_confirmation" value="" type="password">
                @if ($errors->first('password_confirmation'))
                <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                @endif
            </div>

            <div class="col-lg-8 col-lg-offset-2">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="btn btn-primary" value="Register" type="submit">
            </div>

        </form>
    </div>
@stop