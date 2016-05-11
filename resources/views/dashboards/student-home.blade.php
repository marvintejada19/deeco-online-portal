@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @foreach ($classes as $class)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ action('ClassesController@show', [$class->id]) }}">
                        {{ $class->subject_title }} ({{ $class->getSection()->grade_level }} - {{ $class->getSection()->section_name }})
                    </a>
                </div>
                <table class="table">
                    <tr>
                        <th>Faculty:</th>
                        <td>{{ $class->faculty->username }}</td>
                    </tr>
                </table>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
