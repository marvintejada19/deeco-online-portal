@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(count($subjects) == 0)
                <div class="panel panel-default">
                    <div class="panel-body">No subject to show.</div>
                </div>
            @else
            @foreach ($subjects as $subject)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ action('Subjects\SubjectsController@show', [$subject->id]) }}">
                        {{ $subject->subject_title }} ({{ $subject->getSection()->grade_level }} - {{ $subject->getSection()->section_name }})
                    </a>
                </div>
                <table class="table">
                    <tr>
                        <th>Units:</th>
                        <td>{{ $subject->units }}</td>
                    </tr>
                    <tr>
                        <th>Number of students:</th>
                        <td>{{ count($subject->students) }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
