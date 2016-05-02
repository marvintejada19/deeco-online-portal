@extends('layouts.app')

@section('title')
    {{ $topic->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="col-md-6">
        <ol class="breadcrumb pull-right">
            <li><a href="/categories">All categories</a></li>
            <li><a href="/categories/{{ $category->name }}">{{ $category->name }}</a></li>
            <li class="active">{{ $topic->name }}</li>
        </ol>
    </div>
    <br></br><hr/>
    <font size='4'><b>Topic: &nbsp;</b></font><font size='6'>{{ $topic->name }}</font>
    <button type="button" class="btn btn-primary pull-right" onclick="location.href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/create'">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new subtopic
    </button>
    <br></br>
    @foreach ($topic->questionSubtopics as $subtopic)
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href='/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}'>{{ $subtopic->name }}</a>
                @if (strcmp($subtopic->name, 'Default Subtopic') != 0)
                <div class="dropdown pull-right">
                    <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/edit">Edit name</a></li>
                        <li class="divider"></li>
                        <li><a href="/categories/{{ $category->name }}/topics/{{ $topic->name }}/subtopics/{{ $subtopic->name }}/delete">Delete subtopic</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@stop