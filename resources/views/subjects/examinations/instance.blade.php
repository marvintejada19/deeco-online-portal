@extends('layouts.app')

@section('title')
    Examination instance
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title }}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">{{ $examination->title }}</a></li>
        <li class="active">Examination instance</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Answer a sample generated examination
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
                    @if ($hasInstance && $instance->is_finished)
                    <tr>
                        <th colspan="2">
                            <font color='red'>
                                Starting a new examination would delete your previous one.
                            </font>
                        </th>
                        <td colspan="2">
                            <button type="button" class="btn btn-success" onclick="location.href='/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/results'">
                                See results of previous attempt
                            </button>
                        </td> 
                    </tr>
                    @elseif ($hasInstance)
                    <tr>
                        <th colspan="2">
                            <font color='red'>
                                Starting a new examination would delete your previous one.
                            </font>
                        </th>
                        <td colspan="2">
                            <button type="button" class="btn btn-success" onclick="location.href='{{ $continueUrl }}'">
                                Continue answering examinations
                            </button>
                        </td> 
                    </tr>
                    @endif
                    <tr>
                        <th colspan="2">
                            @if (count($examination->questions) == 0)
                                <font color='red'>
                                    No questions added yet. Please add questions first by clicking 
                                        <a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions">here</a>.
                                </font>
                            @endif
                        </th>
                        <td colspan="2">
                            {!! Form::open(['url' => '/subjects/' . $subject->id . '/examinations/' . $examination->id . '/instances']) !!}
                                <button type="submit" class="btn btn-primary" {{ (count($examination->questions) == 0) ? 'disabled' : '' }}>
                                    Start examination
                                </button>
                            {!! Form::close() !!}
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop