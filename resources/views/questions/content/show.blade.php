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
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ $backUrl }}/questions/{{ $question->id }}/edit">Edit question details</a></li>
                            @yield('question-menu')
                        </ul>
                    </div>
                    <br></br>
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