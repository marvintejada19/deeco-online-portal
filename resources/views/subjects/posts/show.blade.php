@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/posts">All posts</a></li>
        <li class="active">{{ $post->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/edit">Edit post</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/posts/{{ $post->id }}/delete">Delete post</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Post details
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $post->title }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{!! $post->body !!}</td>
                    </tr>
                    <tr>
                        <th>Published at:</th><td>{{ $post->getUnformattedDate('published_at') }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $post->getUnformattedDate('created_at') }}</td>
                    </tr>
                </table>
                <div class="well">
                    @if (count($post->files) == 0)
                        No files attached
                    @else
                    Files attached:
                        <ul>
                            @foreach ($post->files as $file)
                                @include('layouts.file')
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop