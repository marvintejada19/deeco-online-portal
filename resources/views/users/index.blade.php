@extends('layouts.app')

@section('title')
    Users
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Users</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-default form-control" onclick="location.href='/users/create'">
                        Create a new user
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-primary form-control" onclick="location.href='/users/school-management'">
                        School Management
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-primary form-control" onclick="location.href='/users/faculty'">
                        Faculty
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-primary form-control" onclick="location.href='/users/students'">
                        Students
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop