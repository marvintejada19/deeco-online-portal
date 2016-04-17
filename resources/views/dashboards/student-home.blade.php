@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @foreach ($classes as $subject)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ action('SubjectsController@show', [$subject->id]) }}">{{ $subject->subject_title }}</a>
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        <dt>Section</dt>
                        <dd>{{ $subject->getSection()->grade_level }} - {{ $subject->getSection()->section_name }}</dd>
                        
                        <dt>Faculty</dt>
                        <dd>{{ $subject->faculty->username }}</dd>

                        <dt>Units</dt>
                        <dd>{{ $subject->units }}</dd>
                    </dl>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
