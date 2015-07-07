@extends('layouts.default')

@section('content')
    <?php
        // Determine the edit profile route
        if (($user->email == Sentry::getUser()->email)) {
            $editAction = route('sentinel.profile.edit');
        } else {
            $editAction =  action('\\Sentinel\Controllers\UserController@edit', [$user->hash]);
        }
    ?>

	<h2>Account Profile</h2>
	
  	<div class="col-lg-6">
        <h4>Account Details</h4>

        <div class="well">
            @if ($user->first_name)
                <p><strong>First Name:</strong> {{ $user->first_name }} </p>
            @endif
            @if ($user->last_name)
                <p><strong>Last Name:</strong> {{ $user->last_name }} </p>
            @endif
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <p><strong>Account created:</strong> {{ $user->created_at }}</p>
            <p><strong>Last Updated:</strong> {{ $user->updated_at }}</p>
            <button class="btn btn-primary" onClick="location.href='{{ $editAction }}'">Edit Profile</button>
        </div>

        <h4>Group Memberships:</h4>

        <div class="well">
            <?php $userGroups = $user->getGroups(); ?>
            <ul>
                @if (count($userGroups) >= 1)
                    @foreach ($userGroups as $group)
                        <li>{{ $group['name'] }}</li>
                    @endforeach
                @else
                    <li>No Group Memberships.</li>
                @endif
            </ul>
        </div>
    </div>

@stop
