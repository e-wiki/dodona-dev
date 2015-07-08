@extends('layouts.default')

@section('content')
    <div class='page-header'>
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a class='btn btn-primary' href="{{ route('sentinel.groups.create') }}">Create Group</a>
            </div>
        </div>
        <h2>Available Groups</h2>
    </div>

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
<!--  
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

