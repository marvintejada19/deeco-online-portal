@extends('layouts.app')

@section('title')
    Add students
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subject-sections">Subjects and Sections</a></li>
        <li><a href="/subject-sections/enrollment">Enrollment</a></li>
        <li class="active">Add students</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            {!! Form::open(['url' => '/subject-sections/enrollment/' . $subject->id . '/add']) !!}
                <div class="input-group">
                    <span class="input-group-addon">Search for username:</span>
                    <input type="text" class="form-control" name="query_text">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </span>
                </div>
            {!! Form::close() !!}
            <br></br>

            @if (is_null($results))
            <div class="well">
                No results found.
            </div>
            @else
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{ $subject->subject_title }}
                </div>
                <table class="table table-bordered table-hover table-responsive">
                    <tr>
                        <td></td>
                        <th>Username:</th>
                    </tr>
                    @foreach ($results as $user)
                        @if (in_array($user->id, $enrolledStudents))
                        <tr class="bg-success">
                            <td>User was already added.</td>
                        @else
                        <tr>
                            <td width="30%">
                                {!! Form::open(['url' => '/subject-sections/enrollment/' . $subject->id . '/add/' . $user->id]) !!}
                                    <button class="btn btn-primary pull-right" type="submit"><span class="glyphicon glyphicon-plus"></span> Add to subject</button>
                                {!! Form::close() !!}
                            </td>
                        @endif
                            <td>{{ $user->username }}</td>
                        </tr>
                    @endforeach()
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@stop