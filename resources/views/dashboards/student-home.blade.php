@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(count($gradeSectionSubjects) == 0)
                <div class="panel panel-default">
                    <div class="panel-body">No classes to show.</div>
                </div>
            @else
                @foreach ($gradeSectionSubjects as $gradeSectionSubject)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ action('ClassesController@show', [$gradeSectionSubject->id]) }}">
                            {{ $gradeSectionSubject->subject->name }}
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
