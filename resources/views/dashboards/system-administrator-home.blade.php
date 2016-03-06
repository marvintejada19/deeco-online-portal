@extends('layouts.app')

@section('navbar-links')
    <li class="dropdown">
        <a id="dLabel" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            User Accounts <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="#">See list of user accounts</a></li>
            <li><a href="/register">Create a new user account</a></li>
            <li><a href="#">Edit a user account</a></li>
            <li><a href="#">Deactivate a user account</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a id="dLabel" data-target="#" href="http://example.com" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Articles <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="#">See list of articles</a></li>
            <li><a href="/articles/create">Create a new article</a></li>
            <li><a href="">Edit a article</a></li>
            <li><a href="#">Deactivate a article</a></li>
        </ul>
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
