@extends('layouts.app')

@section('title')
    Posts
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Posts</li>
    </ol>
    <br></br><hr/>
    <font size='6'>Posts</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/posts/create">
                <span class="glyphicon glyphicon-file"></span> New post
            </a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        @if ($posts->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No posts found.
        </div>
        @else
        <div class="col-md-10 col-md-offset-1">
            @foreach ($posts as $post)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    <div class="dropdown pull-right">
                        <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li><a href="/posts/{{ $post->id }}/edit">Edit post details</a></li>
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