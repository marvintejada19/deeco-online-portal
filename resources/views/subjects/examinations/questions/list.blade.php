@extends('layouts.app')

@section('title')
    All questions
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">{{ $examination->title }}</a></title>
        <li class="active">All questions</li>
    </ol>
    <br></br><hr/>
    <font size='6'>All questions of {{ $examination->title }}</font>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if ($examination->questions->isEmpty())
                <div class="col-md-8 col-md-offset-2 well">
                    No questions added yet. Click <a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions">here</a> to start adding questions. 
                </div>
            @else
            <div class="panel panel-default">
                <table class="table table-hover table-striped table-condensed table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Topic</th>
                        <th>Subtopic</th>
                        <th></th>
                    </tr>
                    @foreach ($examination->questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>
                            @if (!strcmp($question->getQuestionType(), 'Multiple Choice'))
                                <span class="glyphicon glyphicon-option-horizontal"></span>
                            @elseif (!strcmp($question->getQuestionType(), 'True or False'))
                                <span class="glyphicon glyphicon-adjust"></span>
                            @elseif (!strcmp($question->getQuestionType(), 'Fill in the Blanks'))
                                <span class="glyphicon glyphicon-question-sign"></span>
                            @elseif (!strcmp($question->getQuestionType(), 'Matching Type'))
                                <span class="glyphicon glyphicon-th-list"></span>
                            @endif
                        </td>
                        <td>{{ $question->title }}</td>
                        <td>{{ $question->questionSubtopic->questionTopic->questionCategory->name }}</td>
                        <td>{{ $question->questionSubtopic->questionTopic->name }}</td>
                        <td>{{ $question->questionSubtopic->name }}</td>
                        <td><div class="dropdown">
                                <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
                                    <li><a class="bg-danger" href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/remove/{{ $question->id }}">Remove question</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/{{ $question->id }}">View details</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@stop