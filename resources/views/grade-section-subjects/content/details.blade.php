@extends('layouts.app')

@section('title')
    {{ $gradeSectionSubject->subject->name }}
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subjects/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }} ({{ $gradeSectionSubject->gradeSection->getName->name }})</a></li>
        <li class="active">Details</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Details
                </div>
                <table class="table table-responsive">
                    <tr>
                        <th style="width:35%">Title:</th>
                        <td>{{ $gradeSectionSubject->subject->name }}</td>
                    </tr>
                    <tr>
                        <th>Section:</th>
                        <td>{{ $gradeSectionSubject->gradeSection->getName->name }}</td>
                    </tr>
                    <tr>
                        <th>Number of students:</th>
                        <td>{{ count($gradeSectionSubject->gradeSection->students) }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Students enrolled
                </div>
                @if (count($gradeSectionSubject->gradeSection->students) == 0)
                <div class="panel-body">
                    No students enrolled.
                </div>
                @else
                <table class="table">
                    <tr>
                        <td></td>
                        <th>Last name</th>
                        <th>First name</th>
                        <th>ID number</th>
                    </tr>    
                    <?php $count = 1 ?>
                    @foreach ($gradeSectionSubject->gradeSection->students as $student)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $student->getInfo()->lastname }}</td>
                        <td>{{ $student->getInfo()->firstname }}</td>
                        <td>{{ $student->getInfo()->idNumber }}</td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop