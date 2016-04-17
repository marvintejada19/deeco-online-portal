@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-primary" onclick="location.href=''">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new category
                    </button>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    @foreach ($categories as $category)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href='questions/categories/{{ $category->title }}'>{{ $category->title }}</a>
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>
        </div>
    @endforeach
</div>
@stop