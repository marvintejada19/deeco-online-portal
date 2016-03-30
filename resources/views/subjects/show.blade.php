@extends('layouts.app')

@section('title')
    {{ $subject->subject_title }}
@endsection

@section('content')
<div class="container">
    <input class="btn btn-default" type="button" onclick="location.href='/home'" value="Back">
    <hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $subject->subject_title }}</h1>
            <div class="panel panel-default">
                <div class="panel-body">
                    <input class="btn btn-primary" type="button" onclick="location.href='{{ $subject->id }}/posts/create'" value="New article">
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Details
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Students enrolled
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        @if (count($subject->students) == 0)
                            No students enrolled.
                        @else
                            <ul>
                                @foreach ($subject->students as $student)
                                    <li>{{ $student->username }}
                                @endforeach
                            </ul>
                        @endif
                    </dl>
                </div>
            </div>
            @foreach ($subject->subjectPosts as $post)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $post->title }}
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            {{ $post->body }}
                        </dl>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop