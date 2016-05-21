@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="btn btn-primary form-control" onclick="location.href='/users/'">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users
                    </button>
                </div>
                <div class="panel-body">
                    <ul>
                        <li><a href="/users/create">Create a new user</a></li>
                        <hr/>
                        <li><a href="/users/school-management">School management</a></li>
                        <li><a href="/users/faculty">Faculty</a></li>
                        <li><a href="/users/students">Students</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="btn btn-success form-control" onclick="location.href='/subject-sections/'">
                        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Subjects and Sections
                    </button>
                </div>
                <div class="panel-body">
                    <ul>
                        <li><a href="/subject-sections/create">Create a new subject</a></li>
                        <li><a href="/subject-sections/sections/create">Create a new section</a></li>
                        <hr/>
                        <li><a href="/subject-sections/list">See list of subjects</a></li>
                        <li><a href="/subject-sections/sections">See list of sections</a></li>
                        <hr/>
                        <li><a href="/subject-sections/enrollment">Manage enrollment</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="btn btn-info form-control" onclick="location.href='/articles/'">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Articles
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop