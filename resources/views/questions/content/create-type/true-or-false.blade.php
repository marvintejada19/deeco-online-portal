@extends('questions.content.create')

@section('type-content')
<div class="form-group{{ $errors->has('right_answer') ? ' has-error' : '' }}">
	{!! Form::label('right_answer', 'Right answer:', ['class' => 'col-md-4 control-label']) !!}

    <div class="col-md-6">
	    <label class="radio-inline">
	    	{!! Form::radio('right_answer', '1') !!} True
	    </label>
		<label class="radio-inline">
			{!! Form::radio('right_answer', '0') !!} False
		</label>

        @if ($errors->has('right_answer'))
            <span class="help-block">
                <strong>{{ $errors->first('right_answer') }}</strong>
            </span>
        @endif
    </div>
</div>
@endsection