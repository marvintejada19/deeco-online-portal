@extends('layouts.app')

@section('title')
    Subjects
@endsection

@section('content')
<div class="container">
    @include('flash::message')
    <ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subject-sections/">Subjects and Sections</a></li>
        <li class="active">Subjects</li>
    </ol>
    <br></br><hr/>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Subjects
                </div>
                @if (empty($subjects))
                <div class="panel-body">
                    No subjects found.
                </div>
                @else
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <td></td>
                        <th>Title</th>
                        <th>Section</th>
                        <th>Faculty</th>
                        <th>SY</th>
                        <th>No. of students enrolled</th>
                    </tr>   
                    <?php $count = 1 ?> 
                    @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $subject->subject_title }}</td>
                        <td>{{ $subject->section->getName() }}</td>
                        <td>{{ $subject->faculty->username }}</td>
                        <td>{{ $subject->sy }}</td>
                        <td>{{ count($subject->students) }}</td>
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