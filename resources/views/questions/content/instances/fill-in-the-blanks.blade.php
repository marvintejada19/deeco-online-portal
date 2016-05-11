@extends('questions.content.instances.layout')

@section('instance-form')
	<div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
		{!! Form::label('answer', 'Answer:', ['class' => 'col-md-4 control-label']) !!}
		{!! Form::text('answer', $answer, ['class' => 'form-control', 'required']) !!}
		
		@if ($errors->has('answer'))
            <span class="help-block">
                <strong>{{ $errors->first('answer') }}</strong>
            </span>
        @endif
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4 pull-right">
			{!! Form::submit('Submit answer', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
@endsection