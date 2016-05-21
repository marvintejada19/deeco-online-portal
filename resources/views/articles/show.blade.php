@extends('layouts.app')

@section('title')
    {{ $article->title }}
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href='{{ $backButtonPath }}'>Back</a></li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <article class="panel panel-default">
                <div class="panel-heading">
                    {{ $article->title }}
                </div>
                <div class="panel-body">
                    {{ $article->body }}
                    <hr/>
                    <div class="pull-right">
                        <h5>Published at: {{ $article->getUnformattedDate('published_at') }}</h5>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@stop