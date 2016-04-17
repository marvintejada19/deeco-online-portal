@extends('layouts.app')

@section('title')
    {{ $subject->subject_title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <button type="button" class="btn btn-default btn-sm" onclick="location.href='/home'">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back
    </button><hr/>
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
                    <button type="button" class="btn btn-primary" onclick="location.href='/subjects/{{ $subject->id }}/examinations/create'">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> New exam
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