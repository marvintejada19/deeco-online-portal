@extends('layouts.app')

@section('title')
    Grade sections
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li class="active">Grade sections</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Grade sections
                </div>
                @if (empty($gradeSections))
                <div class="panel-body">
                    No grade sections found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Name</th>
                        <th>Number of students</th>
                        <th>School year</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($gradeSections as $gradeSection)
                    <tr>
                        <td>{{ $count }}</td>
                        <td><a href="/grade-sections/{{ $gradeSection->id }}">{{ $gradeSection->getName->getGradeLevel() }} - {{ $gradeSection->getName->name }}</a></td>
                        <td>{{ count($gradeSection->students) }}</td>
                        <td>{{ $gradeSection->schoolYear->name }}</td>
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