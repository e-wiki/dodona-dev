@extends('layouts.default')

@section('content')
    <h2>Available Groups</h2>

	@include('includes.breadcrumb')

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <th class="col-lg-4">Name</th>
                <th class="col-lg-6">Permissions</th>
                <th colspan="2" class="col-lg-2">Options</th>
            </thead>
            <tbody>
            @foreach ($groups as $group)
                <tr>
                    <td class="col-lg-4"><a href="{{ route('sentinel.groups.show', $group->hash) }}">{{ $group->name }}</a></td>
                    <td class="col-lg-6">
                        <?php
                            $permissions = $group->getPermissions();
                            $keys = array_keys($permissions);
                            $last_key = end($keys);
                        ?>
                        @foreach ($permissions as $key => $value)
                            {{ ucfirst($key) . ($key == $last_key ? '' : ', ') }}
                        @endforeach
                    </td>
                    <td class="col-lg-1">
                        <button class="btn btn-primary btn-block btn-xs" onClick="location.href='{{ route('sentinel.groups.edit', [$group->hash]) }}'">Edit</button>
                    </td>
                    <td class="col-lg-1">
                        <button class="btn btn-danger btn-block btn-xs action_confirm {{ ($group->name == 'Admins') ? 'disabled' : '' }}" type="button" data-token="{{ csrf_token() }}" data-method="delete" href="{{ route('sentinel.groups.destroy', [$group->hash]) }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-lg-2">
        <a class='btn btn-primary btn-block' href="{{ route('sentinel.groups.create') }}">Create Group</a>
    </div>
@stop

