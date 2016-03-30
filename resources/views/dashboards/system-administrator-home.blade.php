@extends('layouts.app')

@section('title')
    Articles
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <button type="button" class="btn btn-primary btn-sm" onclick="location.href='/articles/create'">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create new article
            </button>
            <hr/>
            @if(count($articles) == 0)
                <div class="panel panel-default">
                    <div class="panel-body">No article has been published.</div>
                </div>
            @else
                @foreach($articles as $article)
                    <article class="panel panel-default">
                        <div class="panel-heading">
                            <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                            <div class="dropdown pull-right">
                                <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                    <li><a href="/articles/{{ $article->id }}/edit">Edit article</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/articles/{{ $article->id }}/delete">Delete article</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Created at</dt>
                                <dd>{{ $article->created_at }}</dd>
                                
                                <dt>Last edited at</dt>
                                <dd>{{ $article->updated_at }}</dd>
                                
                                <dt>Date to be published</dt>
                                <dd>{{ $article->published_at }}</dd>
                            </dl>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
