@extends('layouts.app')

@section('title')
    Requirements
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Requirements</li>
    </ol>
    <br></br><hr/>
    <font size='6'>Requirements</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/requirements/create">
                <span class="glyphicon glyphicon-paperclip"></span> New requirement
            </a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        @if($requirements->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No requirements found.
        </div>
        @else
        <div class="col-md-10 col-md-offset-1">
            @foreach ($requirements as $requirement)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/requirements/{{ $requirement->id }}">{{ $requirement->title }}</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@stop