@extends('layouts.default')

@section('content')
    <div class='page-header'>
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a class='btn btn-primary' href="{{ route('sentinel.users.create') }}">Create User</a>
            </div>
        </div>
        <h1>Current Users</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <th class="col-lg-4">User</th>
            <th class="col-lg-4">Status</th>
            <th colspan="4" class="col-lg-4">Options</th>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="col-lg-4"><a href="{{ route('sentinel.users.show', array($user->hash)) }}">{{ $user->first_name }} {{ $user->last_name }} &lt;{{ $user->email }}&gt;</a></td>
                    <td class="col-lg-4">{{ $user->status }} </td>
                    <td class="col-lg-1">
                        <button class="btn btn-primary btn-block btn-xs" type="button" onClick="location.href='{{ route('sentinel.users.edit', array($user->hash)) }}'">Edit</button>
                    </td>
                    <td class="col-lg-1">
                        @if ($user->status != 'Suspended')
                            <button class="btn btn-primary btn-block btn-xs" type="button" onClick="location.href='{{ route('sentinel.users.suspend', array($user->hash)) }}'">Suspend</button>
                        @else
                            <button class="btn btn-primary btn-block btn-xs" type="button" onClick="location.href='{{ route('sentinel.users.unsuspend', array($user->hash)) }}'">Un-Suspend</button>
                        @endif
                    </td>
                    <td class="col-lg-1">
                        @if ($user->status != 'Banned')
                            <button class="btn btn-primary btn-block btn-xs" type="button" onClick="location.href='{{ route('sentinel.users.ban', array($user->hash)) }}'">Ban</button>
                        @else
                            <button class="btn btn-primary btn-block btn-xs" type="button" onClick="location.href='{{ route('sentinel.users.unban', array($user->hash)) }}'">Un-Ban</button>
                        @endif
                    </td>
                    <td class="col-lg-1">
                        <button class="btn btn-danger btn-block action_confirm btn-xs {{ ($user->id === 1) ? 'disabled' : '' }}" href="{{ route('sentinel.users.destroy', array($user->hash)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
