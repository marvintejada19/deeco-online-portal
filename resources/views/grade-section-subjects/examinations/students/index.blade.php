@extends('layouts.app')

@section('title')
    Student results in {{ $deployment->examination->description }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subjects/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }}</a></li>
        <li class="active">Student results in {{ $deployment->examination->description }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Scores of students
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <th></th>
                        <th>Student username</th>
                        <th>Score</th>
                        <th>Time started</th>
                        <th>Time ended</th>
                    </tr>
                    <?php $count = 1 ?>
                    @foreach ($gradeSectionSubject->gradeSection->students as $student)
                        @unless ($exams[$student->id] == null)
                        <tr>
                            <th>{{ $count++ }}</th>
                            <th><a href="/subjects/{{ $gradeSectionSubject->id }}/student-results/{{ $deployment->id }}/instances/{{ $exams[$student->id]->id }}">{{ $student->username }}</a></th>
                            <th>{{ $exams[$student->id]->score }}</th>
                            <th>{{ $exams[$student->id]->time_started }}</th>
                            <th>{{ $exams[$student->id]->time_ended }}</th>
                        </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@stop