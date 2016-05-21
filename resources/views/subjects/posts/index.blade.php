@extends('layouts.app')

@section('title')
    Posts
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title }}</a></li>
        <li class="active">All posts</li>
    </ol>
    <br></br><hr/>
    <font size='6'>Posts</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/posts/create">
                <span class="glyphicon glyphicon-file"></span> New post
            </a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        @if($subject->subjectPosts->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No posts found.
        </div>
        @else
        <div class="col-md-10 col-md-offset-1">
            @foreach ($subject->subjectPosts as $post)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}">{{ $post->title }}</a>
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/edit">Edit post details</a></li>
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