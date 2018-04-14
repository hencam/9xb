@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h2 class="mb-3">Add Role</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{action('RoleController@store')}}" method="post">
        <div class="form-group">
            <label for="job_role">Job Role</label>
            <input type="text" name="job_role" class="form-control" placeholder="Enter job role">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url('roles')}}" class="btn btn-secondary float-right" title="Cancel and go back">
            Cancel
        </a>
        @csrf
    </form>
@endsection
