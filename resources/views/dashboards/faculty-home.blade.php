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
            <!--<div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        {!! Form::open(array('url'=>'upload','method'=>'POST', 'files'=>true)) !!}
                            {!! Form::text('file_name', null, ['class' => 'form-control']) !!}
                            {!! Form::file('my_pdf') !!}

                            {!! Form::submit('Upload', ['class'=>'send-btn']) !!}

                        {!! Form::close() !!}
                    </div>
                    -->
            @foreach ($subjects as $subject)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ action('SubjectsController@show', [$subject->id]) }}">{{ $subject->subject_title }}</a>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Section</dt>
                        <dd>{{ $subject->getSection()->grade_level }} - {{ $subject->getSection()->section_name }}</dd>
                        
                        <dt>Units</dt>
                        <dd>{{ $subject->units }}</dd>
                        
                        <dt>Number of students</dt>
                        <dd>{{ count($subject->students) }}</dd>
                    </dl>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
