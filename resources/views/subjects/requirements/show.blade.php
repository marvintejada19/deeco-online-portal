@extends('layouts.app')

@section('title')
    {{ $requirement->title }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title}}</a></li>
        <li><a href="/subjects/{{ $subject->id }}/requirements">All requirements</a></li>
        <li class="active">{{ $requirement->title }}</li>
    </ol>
    <br></br><hr/>
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Menu <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="/subjects/{{ $subject->id }}/requirements/{{ $requirement->id }}/edit">Edit requirement</a></li>
            <li class="divider">
            <li><a href="/subjects/{{ $subject->id }}/requirements/{{ $requirement->id }}/delete">Delete requirement</a></li>
        </ul>
    </div>
    <br></br>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Requirement details
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Title:</th><td>{{ $requirement->title }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">{!! $requirement->body !!}</td>
                    </tr>
                    <tr>
                        <th>Published at:</th><td>{{ $requirement->getUnformattedDate('published_at') }}</td>
                    </tr>
                    <tr>
                        <th>Event start:</th><td>{{ $requirement->getUnformattedDate('event_start') }}</td>
                    </tr>
                    <tr>
                        <th>Event end:</th><td>{{ $requirement->getUnformattedDate('event_end') }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th><td>{{ $requirement->created_at }}</td>
                    </tr>
                </table>
                <div class="well">
                    @if (count($requirement->files) == 0)
                        No files attached
                    @else
                    Files attached:
                        <ul>
                            @foreach ($requirement->files as $file)
                                @include('layouts.file')
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop