@extends('questions.content.create')

@section('type-content')

<div class="form-group{{ $errors->has('right_answer') ? ' has-error' : '' }}">
	{!! Form::label('right_answer', 'Right answer:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
	    {!! Form::textarea('right_answer', null, ['class' => 'form-control']) !!}

	    @if ($errors->has('right_answer'))
	        <span class="help-block">
	            <strong>{{ $errors->first('right_answer') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('wrong_answers[]') ? ' has-error' : '' }}">
	{!! Form::label('wrong_answers[]', 'Wrong answers:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
	@for ($i = 0; $i < $quantity; $i++)
	    {!! Form::textarea('wrong_answers[]', null, ['class' => 'form-control']) !!}
		@endfor

	    @if ($errors->has('wrong_answers[]'))
	        <span class="help-block">
	            <strong>{{ $errors->first('wrong_answers[]') }}</strong>
	        </span>
	    @endif
	</div>
</div>
@endsection