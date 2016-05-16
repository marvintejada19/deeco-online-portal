@extends('layouts.app')

@section('title')
    Examination instance
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All classes</a></li>
        <li><a href="/classes/{{ $subject->id }}">{{ $subject->subject_title }}</a></li>
        <li class="active">{{ $examination->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Answer the examination
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th colspan="2">Title:</th><td colspan="2">{{ $examination->title }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Subject:</th><td colspan="2">{{ $examination->subject->subject_title }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Number of questions:</th><td colspan="2">{{ count($examination->questions) }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Total points:</th><td colspan="2">{{ $examination->total_points }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Created by:</th><td colspan="2">{{ $examination->subject->faculty->username }}</td>
                    </tr>
                    <tr>
                        <th>Available from:</th><td>{{ $examination->getUnformattedDate('exam_start') }}</td>
                        <th>Available until:</th><td>{{ $examination->getUnformattedDate('exam_end') }}</td>
                    </tr>
                    @if ($hasInstance)
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">
                            <button type="button" class="btn btn-success" onclick="location.href='{{ $continueUrl }}'">
                                Continue answering examinations
                            </button>
                        </td> 
                    </tr>
                    @else
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">
                            {!! Form::open(['url' => '/classes/' . $subject->id . '/examinations/' . $examination->id . '/instances']) !!}
                                <button type="submit" class="btn btn-primary" {{ (count($examination->questions) == 0) ? 'disabled' : '' }}>
                                    Start examination
                                </button>
                            {!! Form::close() !!}
                        </td> 
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@stop