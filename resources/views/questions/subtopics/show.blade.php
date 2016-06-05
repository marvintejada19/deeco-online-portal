@extends('layouts.app')

@section('title')
    {{ $subtopic->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/examinations">Back to examinations</a></li>
        <li><a href="/categories">All categories</a></li>
        <li><a href="/categories/{{ $category->name }}">{{ $category->name }}</a></li>
        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}">{{ $topic->name }}</a></li>
        <li class="active">{{ $subtopic->name }}</li>
    </ol>
    <br></br><hr/>
    <font size='4'><b>Subtopic: &nbsp;</b></font><font size='6'>{{ $subtopic->name }}</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new question <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/multiple-choice">
                <span class="glyphicon glyphicon-option-horizontal pull-right"></span> Multiple choice
            </a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/true-or-false">
                <span class="glyphicon glyphicon-adjust pull-right"></span> True or False
            </a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/fill-in-the-blanks">
                <span class="glyphicon glyphicon-question-sign pull-right"></span> Fill in the Blanks
            </a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/match-column-a-with-column-b">
                <span class="glyphicon glyphicon-th-list pull-right"></span> Match Column A & B
            </a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/select-from-the-wordbox">
                <span class="glyphicon glyphicon-unchecked pull-right"></span> Select from the wordbox
            </a></li>
        </ul>
    </div>
    <br></br>
    @if ($subtopic->questions->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No questions in this subtopic yet.
        </div>
    @else
        <table class="table table-responsive table-hover">
        @foreach ($subtopic->questions as $question)
            <tr>
                <td>
                @if (!strcmp($question->getQuestionType(), 'Multiple Choice'))
                    <span class="glyphicon glyphicon-option-horizontal"></span>
                @elseif (!strcmp($question->getQuestionType(), 'True or False'))
                    <span class="glyphicon glyphicon-adjust"></span>
                @elseif (!strcmp($question->getQuestionType(), 'Fill in the Blanks'))
                    <span class="glyphicon glyphicon-question-sign"></span>
                @elseif (!strcmp($question->getQuestionType(), 'Match Column A with Column B'))
                    <span class="glyphicon glyphicon-th-list"></span>
                @elseif (!strcmp($question->getQuestionType(), 'Select from the Wordbox'))
                    <span class="glyphicon glyphicon-unchecked"></span>
                @endif
                </td>
                <td>
                    <a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}">{{ $question->title }}</a>
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}/delete">Delete question</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        </table>
    @endif
</div>
@stop