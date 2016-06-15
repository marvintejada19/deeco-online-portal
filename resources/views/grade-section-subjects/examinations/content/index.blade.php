@extends('layouts.app')

@section('title')
    Examinations
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Examinations</li>
    </ol>
    <br></br><hr/>
    <font size='6'>Examinations</font>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/examinations/create">
                <span class="glyphicon glyphicon-list-alt"></span> New examination
            </a></li>
            <li class="divider">
            <li><a class="bg-info" href="/categories">View all categories</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        @if ($examinations->isEmpty())
        <div class="col-md-8 col-md-offset-2 well">
            No examinations found.
        </div>
        @else
        <div class="col-md-10 col-md-offset-1">
            @foreach ($examinations as $examination)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="/examinations/{{ $examination->id }}">{{ $examination->description }}</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@stop