@unless (!strcmp($part->getQuestionType(), 'Select from the Wordbox') || !strcmp($part->getQuestionType(), 'Match Column A with Column B'))
<div class="form-group">
    {!! Form::label('question_subtopic_id', 'Subtopic', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    	@if (empty($subtopics))
			{!! Form::select('question_subtopic_id', $subtopics, null, ['id' => 'subtopic_div', 'class' => 'form-control', 'placeholder' => 'Please select a category and topic first...', 'required', 'onchange' => 'updateMaxQuantity()']) !!}    		
    	@else
    		{!! Form::select('question_subtopic_id', $subtopics, null, ['id' => 'subtopic_div', 'class' => 'form-control', 'placeholder' => 'Select from the following...', 'required', 'onchange' => 'updateMaxQuantity()']) !!}
    	@endif
    </div>
</div>
@else
    @include('grade-section-subjects.examinations.parts.items.create-ext') 
@endif

@if (!strcmp($part->getQuestionType(), 'Match Column A with Column B') || !strcmp($part->getQuestionType(), 'Select from the Wordbox'))
{!! Form::hidden('quantity', $part->questions_quantity) !!}
@else
<div class="form-group">
    {!! Form::label('quantity', 'Quantity:', ['id' => 'quantity_label', 'class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('quantity', 1, ['id' => 'quantity', 'min' => '1', 'class' => 'form-control', 'required']) !!}
    </div>
</div>
@endif

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

<script type="text/javascript">
    function updateMaxQuantity(){
        var quantityDiv = document.getElementById('quantity');
        var subtopicDiv = document.getElementById('subtopic_div');
        var quantityLabel = document.getElementById('quantity_label');

        switch (subtopicDiv.value) {
            @foreach ($questionCount as $subtopicId => $count)
                case '{{ $subtopicId }}':
                    quantityDiv.max = '{{ $count }}';
                    quantityLabel.innerHTML = 'Quantity: (Max: {{ $count }})';
                    break;
            @endforeach
        }
    }
</script>