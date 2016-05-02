@extends('layouts.app')

@section('title')
    {{ $subtopic->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="col-md-6">
        <ol class="breadcrumb pull-right">
            <li><a href="/categories">All categories</a></li>
            <li><a href="/categories/{{ $category->name }}">{{ $category->name }}</a></li>
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}">{{ $topic->name }}</a></li>
            <li class="active">{{ $subtopic->name }}</li>
        </ol>
    </div>
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
            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/create/matching-type">
                <span class="glyphicon glyphicon-th-list pull-right"></span> Matching Type
            </a></li>
        </ul>
    </div>
    <br></br>
    <?php $count = 0 ?>
    @if ($subtopic->questions->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No questions in this subtopic yet.
        </div>
    @else
        @foreach ($subtopic->questions as $question)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="categories/{categories}/topics/{topics}/subtopics/{subtopics}/questions/{{ $question->id }}">{{ $question->title }}</a>
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/questions/{{ $question->id }}">View details</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    {!! $question->body !!}
                </div>
            </div>
            </div>
        </div>
        <?php $count++ ?>
        @endforeach
    @endif
</div>
@stop