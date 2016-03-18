@extends('layouts.app')

@section('title')
    Home
@endsection

@section('navbar-links')
    <li class="dropdown">
        <a id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            1 <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="/users/list">See list of user accounts</a></li>
            <li><a href="/register">Create a new user account</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            2 <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="/articles/list">See list of articles</a></li>
            <li><a href="/articles/create">Create a new article</a></li>
        </ul>
    </li>
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! Form::open(array('url'=>'upload','method'=>'POST', 'files'=>true)) !!}
                        {!! Form::text('file_name', null, ['class' => 'form-control']) !!}
                        {!! Form::file('my_pdf') !!}

                        {!! Form::submit('Upload', ['class'=>'send-btn']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
