@extends('layouts.app')

@section('title')
    Question details
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="{{ $backUrl }}">Back to page</a></li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Question details
                    @yield('question-menu')
                </div>
            </div>
            <table class="table table-hover">
                <tr>
                    <th>Title:</th><td>{{ $question->title }}</td>
                </tr>
                <tr>
                    <th>Body:</th><td>{!! $question->body !!}</td>
                </tr>
                @yield('question-details')
                <tr>
                    <th>Created by:</th><td>{{ $question->getAuthor() }}</td>
                </tr>
                <tr>
                    <th>Created at:</th><td>{{ $question->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop