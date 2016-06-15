@extends('layouts.app')

@section('title')
	Students submissions
@endsection

@section('content')
<div class="container">
	<ol class="breadcrumb pull-right">
        <li><a href="/home">Home</a></li>
        <li><a href="/subjects/{{ $gradeSectionSubject->id }}">{{ $gradeSectionSubject->subject->name }}</a></li>
        <li class="active">{{ $requirement->requirement->title }} - Student submissions</li>
    </ol>
    <br></br><hr/>	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
			    <div class="panel-heading">
			        Submissions of students
			    </div>
			    <table class="table table-hover">
			        <tr>
			            <th>Name</th>
			            <th>Student ID Number</th>
			            <th>File submitted</th>
			            <th>Submitted at</th>
			        </tr>
			        @foreach ($gradeSectionSubject->gradeSection->students as $student)
			        <tr>
			            <td>{{ $student->getInfo()->lastname }}, {{ $student->getInfo()->firstname }}</td>
			            <td>{{ $student->getInfo()->idNumber }}</td>
			            <td>
			                @if ($submissions[$student->id] == null) 
			                    None
			                @else
			                <?php $file = $submissions[$student->id]->getFile() ?>
			                {!! Form::open(['url' => 'download']) !!}
			                    {!! Form::hidden('fileId', $file->id) !!}
			                    <input type="submit" class="submitLink" value="{{ $file->file_name }}">
			                {!! Form::close() !!}
			                @endif
			            </td>
			            <td>{{ ($submissions[$student->id] == null) ? 'None' : $submissions[$student->id]->submitted_at }}</td>
			        </tr>
			        @endforeach
			    </table>
			</div>
		</div>
	</div>
</div>
@endsection