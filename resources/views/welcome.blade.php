@extends('layouts.app')

@section('title')
    DEECO Online Portal
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(count($articles) == 0)
                <div class="panel panel-default">
                    <div class="panel-body">No article has been published.</div>
                </div>
            @else
                @foreach ($articles as $article)
                    <article class="panel panel-default">
                        <div class="panel-heading">
                            <a href="{{ action('ArticlesController@show', [$article->id]) }}">{{ $article->title }}</a>
                        </div>
                        <div class="panel-body">
                            {{ $article->body }}
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
