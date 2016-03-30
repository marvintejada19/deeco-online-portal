@extends('layouts.app')

@section('title')
    Articles
@endsection

@section('navbar-links')
    <li class="dropdown">
        <a id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            User Accounts <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li>hello</li>
        </ul>
    </li>
    <li class="dropdown">
        <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Articles <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="/articles/list">See list of articles</a></li>
            <li><a href="/articles/create">Create a new article</a></li>
        </ul>
    </li>
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(empty($articles))
                <div class="panel panel-default">
                    <div class="panel-body">No article has been published.</div>
                </div>
            @else
                @foreach($articles as $article)
                    <article class="panel panel-default">
                        <div class="panel-heading">
                            {{ $article->title }}
                        </div>
                        <div class="panel-body">
                            <input class="btn btn-info" type="button" onclick="location.href='/articles/{{ $article->id }}'" value="View article">
                            <input class="btn btn-primary" type="button" onclick="location.href='/articles/{{ $article->id }}/edit'" value="Edit article">
                            <input class="btn btn-danger" type="button" onclick="location.href='/articles/{{ $article->id }}/delete'" value="Delete article">
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
