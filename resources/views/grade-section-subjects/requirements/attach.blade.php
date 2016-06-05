@extends('layouts.app')

@section('title')
	Attach more grade section subjects
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
	            <div class="panel-heading">
	            	Attach more grade section subjects
	            </div>
	            <div class="panel-body">
	            	{!! Form::open(['url' => '/requirements/' . $requirement->id . '/attach']) !!}
	            	<div class="form-group pull-right">
						<div class="col-md-6 col-md-offset-4">
							<label class="btn btn-primary" onclick="attachMore()">
								<span class="glyphicon glyphicon-plus"></span> Attach more grade section subjects
							</label>
						</div>
					</div>
					<table class="table" id="additional_attachments">
						<tr>
							<td>Grade section subject</td>
							<td>Publish on</td>
						</tr>
						<tr>
					        <td>{!! Form::select('grade_section_subject_id[]', $gradeSectionSubjects, null, ['class' => 'form-control', 'required']) !!}</td>
						    <td>{!! Form::input('datetime-local', 'publish_on[]', $timeNow, ['class' => 'form-control', 'required']) !!}</td>
						</tr>
						<tr> 
							<td>Available to students from</td>
							<td>Available to students until</td>
						</tr>
						<tr>
						    <td>{!! Form::input('datetime-local', 'event_start[]', $timeNow, ['class' => 'form-control', 'required']) !!}</td>
						    <td>{!! Form::input('datetime-local', 'event_end[]', $timeEnd, ['class' => 'form-control', 'required']) !!}</td>
						</tr>
						<tr id="additional_attachments">
						</tr>
					</table>

					<div class="form-group pull-right">
						<div class="col-md-6 col-md-offset-4">
							<button type="button" class="btn btn-danger" onclick="location.href='/requirements'">
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
<script type="text/javascript">
	function attachMore(){
		var table = document.getElementById('additional_attachments');
		var row0 = table.insertRow();
		var cell1 = row0.insertCell(0);
		var cell2 = row0.insertCell(1);
		cell1.innerHTML = 	'<hr/>' +
							'Grade section subject<br>' +
							'<select class="form-control" name="grade_section_subject_id[]" placeholder="Select from the following..." required>' +
								@foreach ($gradeSectionSubjects as $id => $name)
								'<option value="{{ $id }}">{{ $name }}</option>' +
								@endforeach
							'</select><br>' +
							'Available to students from<br>' +
							'<input type="datetime-local" name="event_start[]" class="form-control" value="{{ $timeNow }}" required></input>';
		
		cell2.innerHTML = 	'<hr/>' +
							'Publish on<br>' +
							'<input type="datetime-local" name="publish_on[]" class="form-control" value="{{ $timeNow }}" required></input><br>' +
							'Available to students until<br>' +
							'<input type="datetime-local" name="event_end[]" class="form-control" value="{{ $timeEnd }}" required></input>';
	}
</script>
@endsection