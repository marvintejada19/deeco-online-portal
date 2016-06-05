@extends('layouts.app')

@section('title')
    {{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/grade-sections">Grade sections</a></li>
        <li class="active">{{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Details
                </div>
                <table class="table">
                    <tr>
                        <th style="width:50%">Name</th>
                        <td style="width:50%">{{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">School year</th>
                        <td style="width:50%">{{ $gradeSection->schoolYear->name }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Students
                </div>
                @if ($gradeSection->students->isEmpty())
                <div class="panel-body">
                    No students found. Click <a href="/users/enrollment">here</a> to start enrolling students.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Username</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($gradeSection->students as $student)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $student->username }}</td>
                        <td>{{ $student->getInfo()->lastname }}</td>
                        <td>{{ $student->getInfo()->firstname }}</td>
                    </tr>
                    <?php $count++ ?>
                    @endforeach
                </table>
                @endif
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Subjects
                </div>
                @if ($gradeSection->subjects->isEmpty())
                <div class="panel-body">
                    No subjects found. Click <a href="/grade-sections/subjects/assignment">here</a> to start assigning subjects.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Name</th>
                        <th>Faculty</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($gradeSection->subjects as $subject)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $subject->name }}</td>
                        <?php 
                            $faculty = $gradeSection->getGradeSectionSubject($subject)->faculty->first();
                        ?>
                        @if (is_null($faculty))
                        <td class="bg-danger">No faculty assigned yet.</td>            
                        @else
                        <td>
                            {{ $faculty->getInfo()->lastname }}, {{ $faculty->getInfo()->firstname }}
                        </td>
                        @endif
                    </tr>
                    <?php $count++ ?>
                    @endforeach
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop