@extends('layouts.app')

@section('title')
    {{ $subject->subject_title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/subjects">All subjects</a></li>
        <li class="active">{{ $subject->subject_title }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2>{{ $subject->subject_title }}</h2>
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="button" class="btn btn-info" onclick="location.href='/subjects/{{ $subject->id }}/details'">
                        View details
                    </button>
                    <button type="button" class="btn btn-primary" onclick="location.href='/subjects/{{ $subject->id }}/posts/create'">
                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span> New post
                    </button>
                    <button type="button" class="btn btn-primary" onclick="location.href='/subjects/{{ $subject->id }}/requirements/create'">
                        <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> New requirement
                    </button>
                    <button type="button" class="btn btn-warning pull-right" onclick="location.href='/subjects/{{ $subject->id }}/examinations'">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Examinations
                    </button>
                </div>
            </div>
            <?php $i = 0 ?>
            @foreach ($articles as $article)
                @if (!strcmp($types[$i], 'P'))
                    @include('subjects.content.partials.post')
                @elseif (!strcmp($types[$i], 'R'))
                    @include('subjects.content.partials.requirement')
                @endif
                <?php $i++ ?>
            @endforeach
        </div>
    </div>
</div>
@stop