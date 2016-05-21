@extends('layouts.app')

@section('title')
    Subjects and Sections
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Subjects and Sections</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-default form-control" onclick="location.href='/subject-sections/create'">
                        Create a new subject
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-default form-control" onclick="location.href='/subject-sections/sections/create'">
                        Create a new section
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-success form-control" onclick="location.href='/subject-sections/list'">
                        See list of subjects
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-success form-control" onclick="location.href='/subject-sections/sections'">
                        See list of sections
                    </button>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-warning form-control" onclick="location.href='/subject-sections/enrollment'">
                        Manage enrollment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop