@extends('layouts.app')

@section('title')
    Examination results
@endsection

@section('content')
<div class="container">
     <ol class="breadcrumb pull-right">
        <li><a href="/home">All classes</a></li>
        <li><a href="/classes/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }}</a></li>
        <li class="active">Results of {{ $deployment->examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary well">
                <div class="panel-heading">
                    <h5>Results of {{ $deployment->examination->description }}</h5>
                </div>
                <table class="table table-responsive table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $deployment->examination->description }}</td>
                    </tr>
                    <tr>
                        <th>Score:</th>
                        <td>{{ $instance->score }} / {{ $deployment->examination->computeTotalPoints() }}</td>
                    </tr>
                    <tr>
                        <th>Time started:</th>
                        <td>{{ $instance->getUnformattedDate('time_started') }}</td>
                    </tr>
                    <tr>
                        <th>Time ended:</th>
                        <td>{{ $instance->getUnformattedDate('time_ended') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection