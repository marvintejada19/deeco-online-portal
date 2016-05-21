@extends('layouts.app')

@section('title')
    Enrollment
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subject-sections/">Subjects and Sections</a></li>
        <li class="active">Enrollment</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('subjects.enrollment.search')
            @if (!is_null($subjectResult))
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $subjectResult->subject_title }}
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="/subject-sections/enrollment/{{ $subjectResult->id }}/add">Add students</a></li>
                            <li><a href="/subject-sections/enrollment/{{ $subjectResult->id }}/remove">Remove students</a></li>
                        </ul>
                    </div>
                    <br></br>
                </div>
                <table class="table table-striped table-responsive">
                    <tr>
                        <th>Faculty:</th>
                        <td>{{ $subjectResult->faculty->username }}</td>
                    </tr>
                    <tr>
                        <th>Section:</th>
                        <td>{{ $subjectResult->section->getName() }}</td>
                    </tr>
                    <tr>
                        <th>Number of students:</th>
                        <td>{{ count($subjectResult->students) }}</td>
                    </tr>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@stop