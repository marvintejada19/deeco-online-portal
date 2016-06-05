<div class="form-group">
    {!! Form::label('question_type_id', 'Question Type', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('question_type_id', $types, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...', 'required']) !!}
    </div>
</div>

<div class="form-group">
	{!! Form::label('points', 'Points per item:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::number('points', (isset($part->points) ? $part->points : 1), ['min' => '1', 'class' => 'form-control', 'required']) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label('questions_quantity', 'Number of questions:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::number('questions_quantity', (isset($part->questions_quantity) ? $part->questions_quantity : 1), ['min' => '1', 'class' => 'form-control', 'required']) !!}
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/examinations/{{ $examination->id }}/parts'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>