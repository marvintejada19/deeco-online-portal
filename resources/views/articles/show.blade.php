@extends('layouts.app')

@section('title')
    {{ $article->title }}
@endsection

@section('content')
<div class="container">
    <button type="button" class="btn btn-default btn-sm" onclick="location.href='{{ $backButtonPath }}'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <article class="panel panel-default">
                <div class="panel-heading">
                    {{ $article->title }}
                </div>
                <div class="panel-body">
                    {{ $article->body }}
                </div>
            </article>
        </div>
    </div>
</div>
@stop