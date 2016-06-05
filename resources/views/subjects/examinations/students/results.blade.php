@extends('layouts.app')

@section('title')
    Results of {{ $instance->user->username }} in {{ $examination->description }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">{{ $examination->description }}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/student-results">Student results in {{ $examination->description }}</a></li>
        <li class="active">Results of {{ $instance->user->username }} in {{ $examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Summary
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Student username</th>
                        <th>Score</th>
                        <th>Time started</th>
                        <th>Time ended</th>
                    </tr>
                    <tr>
                        <th>{{ $instance->user->username }}</th>
                        <th>{{ $instance->score }}</th>
                        <th>{{ $instance->time_started }}</th>
                        <th>{{ $instance->time_ended }}</th>
                    </tr>
                </table>
            </div>
            @foreach ($questions as $question)
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! $question->body !!}
                </div>
                <table class="table table-responsive">
                    @if (!strcmp($question->getQuestionType(), 'Select from the Wordbox') || !strcmp($question->getQuestionType(), 'Match Column A with Column B'))
                    <tr>
                        <td style="width:30%"></td>
                        <th style="width:35%">Your answer:</th>
                        <th>Correct answer:</th>
                    </tr>
                    @for ($i = 0; $i < count($answers[$question->id]); $i++)
                    <tr>
                        <td>{{ $items[$question->id][$i] }}</td>
                        <td>{{ $answers[$question->id][$i] }}</td>
                        <td>{{ $correctAnswers[$question->id][$i] }}</td>
                    </tr>
                    @endfor
                    @elseif (!strcmp($question->getQuestionType(), 'True or False'))
                    <tr>
                        <th style="width:30%">Your answer:</th>
                        <td>{{ ($answers[$question->id] == 1) ? 'True' : 'False' }}</td>
                    </tr>
                    <tr>
                        <th>Correct answer:</th>
                        <td>{{ ($correctAnswers[$question->id] == 1) ? 'True' : 'False' }}</td>
                    </tr>
                    @else
                    <tr>
                        <th style="width:30%">Your answer:</th>
                        <td>{!! $answers[$question->id] !!}</td>
                    </tr>
                    <tr>
                        <th>Correct answer:</th>
                        <td>{!! $correctAnswers[$question->id] !!}</td>
                    </tr>
                    @endif
                </table>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop