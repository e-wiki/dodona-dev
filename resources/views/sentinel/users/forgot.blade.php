@extends('layouts.default')

@section('content')
    <div class="col-lg-4 col-lg-offset-4">
        <form method="POST" action="{{ route('sentinel.reset.request') }}" accept-charset="UTF-8">

            <h2>Forgot your Password?</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error has-feedback' : '' }}">
                <input class="form-control" placeholder="E-mail" autofocus="autofocus" name="email" type="text" value="{{ Input::old('name') }}">
                @if ($errors->first('email'))
                <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                @endif
            </div>

            <div class="col-lg-8 col-lg-offset-2">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <input class="btn btn-primary" value="Send Instructions" type="submit">
            </div>

        </form>
  	</div>
@stop