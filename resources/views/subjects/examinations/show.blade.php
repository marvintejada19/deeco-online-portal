@extends('layouts.app')

@section('title')
    {{ $examination->title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/examinations">All examinations</a></li>
        <li class="active">{{ $examination->title }}</li>
    </ol>
    <br></br><hr/>
    <font size='6'>{{ $examination->title }}</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions">
                <span class="glyphicon glyphicon-wrench"></span> Add/remove questions
            </a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/questions/list">View all added questions</a></li>
            <li class="divider">
            <li><a class="bg-info" href="/categories/subjects/{{ $subject->id }}">View all categories</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop