@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <table class="table">
            <tr>
            <td style="width:33%">
                <button type="button" class="btn btn-info form-control" onclick="location.href='/posts'">
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Posts
                </button>
            </td>
            <td style="width:33%">
                <button type="button" class="btn btn-success form-control" onclick="location.href='/requirements'">
                    <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Requirements
                </button>
            </td>
            <td style="width:33%">
                <button type="button" class="btn btn-warning form-control" onclick="location.href='/examinations'">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Examinations
                </button>
            </td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if(count($gradeSectionSubjects) == 0)
                <div class="panel panel-default">
                    <div class="panel-body">Nothing to show.</div>
                </div>
            @else
                @foreach ($gradeSectionSubjects as $gradeSectionSubject)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="/subjects/{{ $gradeSectionSubject->id }}">
                            {{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
