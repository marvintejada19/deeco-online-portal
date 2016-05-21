@unless (!strcmp($part->getQuestionType(), 'Select from the Wordbox') || !strcmp($part->getQuestionType(), 'Match Column A with Column B'))
<div class="form-group">
    {!! Form::label('question_subtopic_id', 'Subtopic', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    	@if (empty($subtopics))
			{!! Form::select('question_subtopic_id', $subtopics, null, ['class' => 'form-control', 'placeholder' => 'Please select a category and topic first...', 'required']) !!}    		
    	@else
    		{!! Form::select('question_subtopic_id', $subtopics, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...', 'required']) !!}
    	@endif
    </div>
</div>
@else
    @include('subjects.examinations.parts.items.create-ext') 
@endif

<div class="form-group">
    {!! Form::label('quantity', 'Quantity:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('quantity', 1, ['min' => '1', 'class' => 'form-control', 'required']) !!}
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