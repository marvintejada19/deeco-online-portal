@extends('layouts.app')

@section('title')
    {{ $subject->subject_title }}
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">All subjects</a></li>
        <li><a href="/subjects/{{ $subject->id }}">{{ $subject->subject_title }}</a></li>
        <li class="active">Details</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Details
                </div>
                <table class="table table-striped table-responsive">
                    <tr>
                        <th>Title:</th>
                        <td>{{ $subjectResult->subject_title }}</td>
                    </tr>
                    <tr>
                        <th>Section:</th>
                        <td>{{ $subjectResult->section->getName() }}</td>
                    </tr>
                    <tr>
                        <th>Number of students:</th>
                        <td>{{ count($subjectResult->students) }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Students enrolled
                </div>
                <div class="panel-body">
                    <dl class="dl-horizontal">
                        @if (count($subject->students) == 0)
                            No students enrolled.
                        @else
                            <ul>
                                @foreach ($subject->students as $student)
                                    <li>{{ $student->username }}
                                @endforeach
                            </ul>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@stop