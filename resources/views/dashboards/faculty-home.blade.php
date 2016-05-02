@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @foreach ($subjects as $subject)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ action('Subjects\SubjectsController@show', [$subject->id]) }}">{{ $subject->subject_title }}</a>
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
