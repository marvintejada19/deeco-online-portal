@extends('questions.content.instances.layout')

@section('instance-form')
	<div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
		<table class="table table-hover table-bordered">
		    <tr>
				<td><label class="radio-inline">
					@if ($answer == '1')
			    	{!! Form::radio('answer', '1', ['checked']) !!} True
			    	@else
			    	{!! Form::radio('answer', '1') !!} True
			    	@endif
			    </label></td>
		   	</tr>
			<tr>
				<td><label class="radio-inline">
					@if($answer == '0')
			    	{!! Form::radio('answer', '0', ['checked']) !!} False
					@else					
					{!! Form::radio('answer', '0') !!} False
			    	@endif
			    </label></td>
		   	</tr>
		</table>

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