@extends('questions.content.create')

@section('type-content')
<div class="form-group{{ $errors->has('right_answer') ? ' has-error' : '' }}">
	{!! Form::label('right_answer', 'Right answer:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
	    {!! Form::text('right_answer', null, ['class' => 'form-control']) !!}

	    @if ($errors->has('right_answer'))
	        <span class="help-block">
	            <strong>{{ $errors->first('right_answer') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('wrong_answers') ? ' has-error' : '' }}">
	{!! Form::label('wrong_answers', 'Wrong Answers: (Enter at least one)', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		<div class="control-group">
			{!! Form::text('wrong_answers', null, ['id' => 'wrong_answers']) !!}

			@if ($errors->has('wrong_answers'))
	        <span class="help-block">
	            <strong>{{ $errors->first('wrong_answers') }}</strong>
	        </span>
	    @endif
		</div>
		<script>
		$('#wrong_answers').selectize({
			plugins: ['restore_on_backspace', 'remove_button'],
			delimiter: '|',
			persist: false,
			createOnBlur: true,
			create: function(input) {
		        return {
		            value: input,
		            text: input
		        }
		    }
		});
		</script>
	</div>
</div>
@endsection