@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h2 class="mb-3">Add Employee</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{action('EmployeeController@store')}}" method="post">
        <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" name="firstname" class="form-control" placeholder="Enter firstname" value="{{ old('firstname') }}">
        </div>
        <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname" class="form-control" placeholder="Enter lastname" value="{{ old('lastname') }}">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="text" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="job_role">Job role</label>
            @if (count($roles) > 0)
                <select name="role_id" class="form-control" size=1>
                    <option value="">- no role -</option>
                    @foreach ($roles as $role)
                        @if ($role->cnt >= \Config::get('constants.max_roles_assigned'))
                            <option value="{{$role->id}}" DISABLED>
                        @elseif ($role->id == $request->old('role_id'))
                            <option value="{{$role->id}}" SELECTED>
                        @else
                            <option value="{{$role->id}}">
                        @endif
                            {{$role->job_role}}
                        </option>
                    @endforeach
                </select>
                <small id="role_idHelp" class="form-text text-muted">Roles can be assigned to a max of 4 employees. You will not be able to select roles already assigned to 4 employees.</small>
            @else
                <p>There are no roles on the system!</p>
                <input type="hidden" name="role_id" value="">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url('employees')}}" class="btn btn-secondary float-right" title="Cancel and go back">
            Cancel
        </a>
        @csrf
    </form>
@endsection
