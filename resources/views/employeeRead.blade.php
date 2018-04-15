@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <a href="{{url('employees')}}" class="btn btn-secondary float-right" title="Back to employees">
        Back to employees
    </a>
    <h2 class="mb-4">View Employee</h1>
    @isset($employee)
        @if (count($employee) == 1)
            <div class="row h4 mb-4">
                <div class="col-4">Employee ID:</div>
                <div class="col-4">{{$employee[0]->id}}</div>
            </div>
            <div class="row h4 mb-4">
                <div class="col-4">First name:</div>
                <div class="col-4">{{$employee[0]->firstname}}</div>
            </div>
            <div class="row h4 mb-4">
                <div class="col-4">Last name:</div>
                <div class="col-4">{{$employee[0]->lastname}}</div>
            </div>
            <div class="row h4 mb-4">
                <div class="col-4">Email:</div>
                <div class="col-4">{{$employee[0]->email}}</div>
            </div>
            <div class="row h4 mb-4">
                <div class="col-4">Job role:</div>
                <div class="col-4">{{$employee[0]->job_role}}</div>
            </div>
        @else
        <p>Sorry that record could not be found.</p>
        @endif
    @endisset
@endsection
