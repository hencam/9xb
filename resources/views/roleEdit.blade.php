@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @isset($roles)
        @if (count($roles) == 1)
            <h2 class="mb-3">Edit Role</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach ($roles as $role)
                <form action="{{action('RoleController@update', $role->id)}}" method="post">
                    <div class="form-group">
                        <label for="job_role">Job Role</label>
                        <input type="text" name="job_role" class="form-control" placeholder="Enter job role" value="{{$role->job_role}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url('roles')}}" class="btn btn-secondary float-right" title="Cancel and go back">
                        Cancel
                    </a>
                    @csrf
                    <input name="_method" type="hidden" value="PATCH">
                </form>
            @endforeach
        @endif
    @endisset
@endsection
