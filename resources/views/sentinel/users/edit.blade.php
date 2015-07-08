@extends('layouts.default')

@section('content')
<?php
    // Pull the custom fields from config
    $isProfileUpdate = ($user->email == Sentry::getUser()->email);
    $customFields = config('sentinel.additional_user_fields');

    // Determine the form post route
    if ($isProfileUpdate) {
        $profileFormAction = route('sentinel.profile.update');
        $passwordFormAction = route('sentinel.profile.password');
    } else {
        $profileFormAction =  route('sentinel.users.update', $user->hash);
        $passwordFormAction = route('sentinel.password.change', $user->hash);
    }
?>

    <h2>
        Edit
        @if ($isProfileUpdate)
            Your
        @else
            {{ $user->email }}'s
        @endif
        Account
    </h2>

@if (! empty($customFields))
    <h4>Profile</h4>

    <div class="col-lg-12">
        <form method="POST" action="{{ $profileFormAction }}" accept-charset="UTF-8" class="form-horizontal" role="form">
            <input name="_method" value="PUT" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">

            @foreach(config('sentinel.additional_user_fields') as $field => $rules)
            <div class="form-group {{ ($errors->has($field)) ? 'has-error' : '' }}" for="{{ $field }}">
                <label for="{{ $field }}" class="col-lg-1 control-label">{{ ucwords(str_replace('_',' ',$field)) }}</label>
                <div class="col-lg-5">
                    <input class="form-control" name="{{ $field }}" type="text" value="{{ Input::old($field) ? Input::old($field) : $user->$field }}">
                    {{ ($errors->has($field) ? $errors->first($field) : '') }}
                </div>
            </div>
            @endforeach

            <div class="form-group">
    			{!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-2">
                    <input class="btn btn-primary btn-block" value="Submit Changes" type="submit">
                </div>
            </div>

        </form>
    </div>
    <br>
@endif

@if (Sentry::getUser()->hasAccess('admin') && ($user->hash != Sentry::getUser()->hash))
    <h4>Group Memberships</h4>
    <div class="col-lg-12">
        <form method="POST" action="{{ route('sentinel.users.memberships', $user->hash) }}" accept-charset="UTF-8" class="form-horizontal" role="form">

            <div class="form-group">
    			{!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-11">
                    @foreach($groups as $group)
                        <label class="checkbox-inline">
                            <input type="checkbox" name="groups[{{ $group->name }}]" value="1" {{ ($user->inGroup($group) ? 'checked' : '') }}> {{ $group->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
    			{!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-2">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary btn-block" value="Update Memberships" type="submit">
                </div>
            </div>

        </form>
    </div>
    <br>
@endif

    <h4>Change Password</h4>
    <div class="col-lg-12">
        <form method="POST" action="{{ $passwordFormAction }}" accept-charset="UTF-8" class="form-horizontal" role="form">

            @if(! Sentry::getUser()->hasAccess('admin'))
            <div class="form-group {{ $errors->has('oldPassword') ? 'has-error' : '' }}">
                <label for="oldPassword" class="col-lg-1">Old</label>
                <div class="col-lg-5 {{ $errors->first('oldPassword') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Old Password" name="oldPassword" value="" id="oldPassword" type="password">
                    @if ($errors->first('oldPassword'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>
            @endif

            <div class="form-group {{ $errors->has('newPassword') ? 'has-error' : '' }}" for="newPassword">
                <label for="newPassword" class="col-lg-1">New</label>
                <div class="col-lg-5 {{ $errors->first('newPassword') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="New Password" name="newPassword" value="" id="newPassword" type="password">
                    @if ($errors->first('newPassword'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('newPassword_confirmation') ? 'has-error' : '' }}" for="newPassword_confirmation">
                <label for="newPassword_confirmation" class="col-lg-1">Confirm</label>
                <div class="col-lg-5 {{ $errors->first('newPassword_confirmation') ? 'has-error has-feedback' : '' }}">
                    <input class="form-control" placeholder="Confirm New Password" name="newPassword_confirmation" value="" id="newPassword_confirmation" type="password">
                    @if ($errors->first('newPassword_confirmation'))
                    <span class="form-control-feedback glyphicon glyphicon-alert"></span>
                    @endif
                </div>
            </div>

            <div class="form-group">
    			{!! Form::label(NULL, NULL, ['class' => 'col-lg-1 control-label']) !!}
                <div class="col-lg-2">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                    <input class="btn btn-primary btn-block" value="Change Password" type="submit">
                </div>
            </div>
            
        </form>
    </div>
@stop
