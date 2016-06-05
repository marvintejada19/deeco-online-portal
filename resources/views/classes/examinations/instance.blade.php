@extends('layouts.app')

@section('title')
    Deployment instance
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/classes/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }}</a></li>
        <li class="active">{{ $deployment->examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Answer the examination
                </div>
                <table class="table table-hover">
                    <tr>
                        <th style="width:50%" colspan="2">Title:</th><td style="width:50%"  colspan="2">{{ $deployment->examination->description }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Created by:</th><td colspan="2">{{ $deployment->examination->faculty->getFullName() }}</td>
                    </tr>
                    <tr>
                        <th style="width:25%">Available from:</th><td style="width:25%">{{ $deployment->getUnformattedDate('exam_start') }}</td>
                        <th style="width:25%">Available until:</th><td style="width:25%">{{ $deployment->getUnformattedDate('exam_end') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">
                            {!! Form::open(['url' => '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances']) !!}
                                <button type="submit" class="btn btn-primary">
                                    Start examination
                                </button>
                            {!! Form::close() !!}
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop