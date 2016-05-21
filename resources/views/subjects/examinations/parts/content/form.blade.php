<div class="form-group">
    {!! Form::label('question_type_id', 'Question Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('question_type_id', $types, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...', 'required']) !!}
    </div>
</div>

<div class="form-group">
	{!! Form::label('points', 'Points per item:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::number('points', 1, ['min' => '1', 'class' => 'form-control', 'required']) !!}
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/subjects/{{ $subject->id }}/examinations/{{ $examination->id }}/parts'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>