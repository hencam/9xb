@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <a href="{{action('EmployeeController@index')}}" class="btn btn-secondary float-right mr-3" title="Back to employees">
        Back to employees
    </a>
    <a href="{{action('RoleController@create')}}" class="btn btn-primary float-right mr-3" title="Add a new employee">
        Add Role
    </a>
    @isset($roles)
        @if (count($roles) > 0)
            <h2 class="mb-4">Role List</h2>
            <table class="w-100">
                <tr>
                    <th>Job role</th>
                    <th>Employees</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                @foreach ($roles as $role)
                <tr class="border rounded">
                    <td class="p-1">
                        <p>{{ $role->job_role }}</p>
                    </td>
                    <td class="p-1">
                        <p>{{ $role->cnt }}</p>
                    </td>
                    <td class="p-1 text-center">
                        <a href="{{action('RoleController@edit', $role->id)}}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="p-1 text-center">
                        <a href="#" onClick="if (confirm('Are you sure you want to delete this role?@if ($role->cnt > 0) \nIt has employees assigned to it! @endif')) document.getElementById('deleteRole_{{$role->id}}').submit(); else return(false);">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <td class="invisible">
                        <form action="{{action('RoleController@destroy', $role->id)}}" method="post" id="deleteRole_{{$role->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>There are no roles!</p>
        @endif
    @endisset
@endsection
