@extends('layouts.app')

@section('title')
    Answer the examination
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
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Answer the examination
                </div>
                <table class="table">
                    <tr>
                        <th style="width:50%" colspan="2">Subcategory:</th><td style="width:50%"  colspan="2">{{ $deployment->examination->subcategory }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Description:</th><td colspan="2">{{ $deployment->examination->description }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Total points</th><td colspan="2">{{ $deployment->examination->computeTotalPoints() }}</td>
                    </tr>
                    <tr>
                        <th style="width:25%">Available from:</th><td style="width:25%">{{ $deployment->getUnformattedDate('exam_start') }}</td>
                        <th style="width:25%">Available until:</th><td style="width:25%">{{ $deployment->getUnformattedDate('exam_end') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="2">
                            @if ($examStart < $timeNow && $timeNow < $examEnd)
                            {!! Form::open(['url' => '/classes/' . $gradeSectionSubject->id . '/deployments/' . $deployment->id . '/instances']) !!}
                                <button type="submit" class="btn btn-primary">
                                    Start examination
                                </button>
                            {!! Form::close() !!}
                            @else
                                <button class="btn btn-primary" disabled>
                                    Start examination
                                </button>
                            @endif
                        </td> 
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop