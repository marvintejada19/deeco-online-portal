@extends('layouts.app')

@section('title')
    {{ $article->title }}
@endsection

@section('content')
<div class="container">
    <input class="btn btn-default" type="button" onclick="location.href='{{ URL::previous() }}'" value="Back">
    <hr/>
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