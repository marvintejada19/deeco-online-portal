@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if(empty($articles))
                    <div class="panel-body">No article has been published.</div>
                @else
                    @foreach($articles as $article)
                    <article>
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
</div>
@endsection
