@extends('layouts.app')

@section('title')
    Remove students
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subject-sections">Subjects and Sections</a></li>
        <li><a href="/subject-sections/enrollment">Enrollment</a></li>
        <li class="active">Remove students</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if ($subject->students->isEmpty())
            <div class="well">
                No users enrolled.
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
                    @foreach ($subject->students as $user)
                        <tr>
                            <td width="30%">
                                {!! Form::open(['url' => '/subject-sections/enrollment/' . $subject->id . '/remove/' . $user->id]) !!}
                                    <button class="btn btn-danger pull-right" type="submit"><span class="glyphicon glyphicon-remove"></span> Remove from this subject</button>
                                {!! Form::close() !!}
                            </td>
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