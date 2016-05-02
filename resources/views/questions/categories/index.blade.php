@extends('layouts.app')

@section('title')
    Categories
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="col-md-6">
        <ol class="breadcrumb pull-right">
            <li><a href="{{ $url }}">Back to subjects</a></li>
        </ol>
    </div>
    <br></br><hr/>
    <font size='6'>Categories</font>
    <button type="button" class="btn btn-primary pull-right" onclick="location.href='/categories/create'">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add a new category
    </button>
    <br></br>
    @foreach ($categories as $category)
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href='/categories/{{ $category->name }}'>{{ $category->name }}</a>
                        @if (strcmp($category->name, 'Default Category') != 0)
                        <div class="dropdown pull-right">
                            <button class="btn btn-default btn-xs dropdown-toggle" id="dLabel" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a href="/categories/{{ $category->name }}/edit">Edit name</a></li>
                                <li class="divider"></li>
                                <li><a href="/categories/{{ $category->name }}/delete">Delete category</a></li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@stop