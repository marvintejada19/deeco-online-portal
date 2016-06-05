<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<label class="btn btn-primary" onclick="attachMore()">
			<span class="glyphicon glyphicon-plus"></span> Attach more grade section subjects
		</label>
	</div>
</div>

<table class="table" id="additional_attachments">
	<tr>
		<th>Grade section subject</th>
		<th>Publish on</th>
	</tr>
	<tr>
        <td>{!! Form::select('grade_section_subject_id[]', $gradeSectionSubjects, null, ['class' => 'form-control', 'required']) !!}</td>
	    <td>{!! Form::input('datetime-local', 'publish_on[]', $timeNow, ['class' => 'form-control', 'required']) !!}</td>
	</tr>
	<tr id="additional_attachments">
	</tr>
</table>

<script type="text/javascript">
	function attachMore(){
		var table = document.getElementById('additional_attachments');
		var row = table.insertRow();
		var cell1 = row.insertCell(0);
		var cell2 = row.insertCell(1);

		cell1.innerHTML = 	'<select class="form-control" name="grade_section_subject_id[]" placeholder="Select from the following..." required>' +
								@foreach ($gradeSectionSubjects as $id => $name)
								'<option value="{{ $id }}">{{ $name }}</option>' +
								@endforeach
							'</select>';
		cell2.innerHTML = 	'<input type="datetime-local" name="publish_on[]" class="form-control" value="{{ $timeNow }}" required></input>';	
	}
</script>
