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
                    <button type="button" class="btn btn-primary pull-right" onclick="location.href='{{ $generateUrl }}'">
                        Generate sample instance
                    </button>
                    <br></br>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $question->title }}</td>
                    </tr>
                    <tr>
                        <th>Body:</th><td>{!! $question->body !!}</td>
                    </tr>
                    <tr>
                        <th>Points per item:</th><td>{{ $question->points }}</td>
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
</div>
@stop