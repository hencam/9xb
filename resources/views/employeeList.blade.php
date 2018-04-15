@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (count($employees) < \Config::get('constants.max_employees'))
        <a href="{{action('EmployeeController@create')}}" class="btn btn-primary float-right mr-3" title="Add a new employee">
            Add employee
        </a>
    @endif
    <a href="{{action('RoleController@index')}}" class="btn btn-secondary float-right mr-3" title="Manage roles">
        Manage Roles
    </a>
    @isset($employees)
        @if (count($employees) > 0)
            <h2 class="mb-4">Employee List</h2>
            <table class="w-100">
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email Address</th>
                    <th>Job Role</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                @foreach ($employees as $employee)
                <tr class="border rounded">
                    <td class="p-1">
                        <p>{{ $employee->firstname }}</p>
                    </td>
                    <td class="p-1">
                        <p>{{ $employee->lastname }}</p>
                    </td>
                    <td class="p-1">
                        <p>{{ $employee->email }}</p>
                    </td>
                    <td class="p-1">
                        <p>{{ $employee->job_role }}</p>
                    </td>
                    <td class="p-1 text-center">
                        <a href="{{action('EmployeeController@show', $employee->id)}}" title="view employee record">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <td class="p-1 text-center">
                        <a href="{{action('EmployeeController@edit', $employee->id)}}" title="edit employee record">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="p-1 text-center">
                        <a href="#" onClick="if (confirm('Are you sure you want to delete this employee?')) document.getElementById('deleteEmployee_{{$employee->id}}').submit(); else return(false);" title="delete employee record">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <td class="invisible">
                        <form action="{{action('EmployeeController@destroy', $employee->id)}}" method="post" id="deleteEmployee_{{$employee->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>There are no employees!</p>
        @endif
    @endisset
@endsection
