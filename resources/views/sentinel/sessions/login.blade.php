@extends('layouts.default')

@section('content')
    <div class="col-lg-4 col-lg-offset-4">
        <h1 class="text-center">Dodona Framework</h1>

        <br>

        <form method="POST" action="{{ route('sentinel.session.store') }}" accept-charset="UTF-8">
            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Email" autofocus="autofocus" name="email" type="text" value="{{ Input::old('email') }}">
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                <input class="form-control" placeholder="Password" name="password" value="" type="password">
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>

            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            <div class="col-lg-8 col-lg-offset-2">
                <input class="btn btn-primary btn-block" value="Sign In" type="submit">
            </div>

        </form>
    </div>

@stop