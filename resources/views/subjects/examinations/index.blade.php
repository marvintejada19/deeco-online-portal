@extends('layouts.app')

@section('title')
    Examinations
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title }}</a></li>
        <li class="active">All examinations</li>
    </ol>
    <br></br><hr/>
    <font size='6'>Examinations</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/examinations/create">
                <span class="glyphicon glyphicon-list-alt"></span> New examination
            </a></li>
            <li class="divider">
            <li><a class="bg-info" href="/categories/subjects/{{ $subject->id }}">View all categories</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        @if($subject->subjectExaminations->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No examinations found.
        </div>
        @else
        <div class="col-md-10 col-md-offset-1">
            @foreach ($subject->subjectExaminations as $examination)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}">{{ $examination->title }}</a>
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/edit">Edit examination</a></li>
                            <li class="divider"></li>
                            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/delete">Delete examination</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@stop