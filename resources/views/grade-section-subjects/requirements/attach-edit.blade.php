@extends('layouts.app')

@section('title')
	Attach grade section subjects
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
	            <div class="panel-heading">
	            	Attach grade section subjects
	            </div>
	            <div class="panel-body">
	            	{!! Form::open(['url' => '/requirements/' . $requirement->id . '/attach/' . $attachment->id]) !!}
					<table class="table">
						<tr>
							<td>Grade section subject</td>
							<td>Publish on</td>
						</tr>
						<tr>
					        <td>{!! Form::label('', $gradeSectionSubject->subject->name . ' (' . $gradeSectionSubject->gradeSection->getName->name . ')', null, ['class' => 'form-control', 'required']) !!}
					        	{!! Form::hidden('grade_section_subject_id', $gradeSectionSubject->id) !!}
					        </td>
						    <td>{!! Form::input('datetime-local', 'publish_on', $attachment->publish_on, ['class' => 'form-control', 'required']) !!}</td>
						</tr>
						<tr> 
							<td>Available to students from</td>
							<td>Available to students until</td>
						</tr>
						<tr>
						    <td>{!! Form::input('datetime-local', 'event_start', $attachment->event_start, ['class' => 'form-control', 'required']) !!}</td>
						    <td>{!! Form::input('datetime-local', 'event_end', $attachment->event_end, ['class' => 'form-control', 'required']) !!}</td>
						</tr>
					</table>

					<div class="form-group pull-right">
						<div class="col-md-6 col-md-offset-4">
							<button type="button" class="btn btn-danger" onclick="location.href='/requirements/{{ $requirement->id }}'">
								Back
							</button>
						</div>
					</div>

					<div class="form-group pull-right">
						<div class="col-md-6 col-md-offset-4">
							{!! Form::submit('Attach requirement', ['class' => 'btn btn-primary form-control']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection