@extends('layouts.app')

@section('title')
    Requirement submission status
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All classes</a></li>
        <li><a href="/classes/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }}</a></li>
        <li class="active">{{ $subjectRequirement->requirement->title }} - Submission status</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $subjectRequirement->requirement->title }} - Submission status
                    <div class="pull-right">
                        Status: {!! $status !!}
                    </div>
                </div>
                <div class="panel panel-body">
                    <table class="table table-responsive">
                        <tr>
                            <th>Available from:</th><td>{{ $subjectRequirement->getUnformattedDate('event_start') }}</td>
                            <th>Available until:</th><td>{{ $subjectRequirement->getUnformattedDate('event_end') }}</td>
                        </tr>
                    </table>
                    <hr/>
                    <div class="well">
                        @if ($instance)
                            Your submitted file:
                            @include('layouts.file')
                            <h4><label class="label label-primary">Submitted at: {{ $instance->submitted_at }}</label></h4>
                        @else
                            No files submitted yet.
                        @endif
                    </div>
                    @if ($ongoing)
                    {!! Form::open(['url' => 'classes/' . $gradeSectionSubject->id . '/requirements/' . $subjectRequirement->id . '/submission', 'files'=>true]) !!}
                    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                        {!! Form::label('file', 'Upload file', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::file('file') !!}

                            <h5><font color='red'>* 16mb file size limit. Only one file may be uploaded.</font></h5>
                            @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('file') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="form-group pull-right">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="button" class="btn btn-danger" onclick="location.href='/classes/{{ $gradeSectionSubject->id }}'">
                                Back
                            </button>
                        </div>
                    </div>
                    @if ($ongoing)
                    <div class="form-group pull-right">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop