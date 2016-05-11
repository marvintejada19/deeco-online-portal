@extends('questions.content.instances.layout')

@section('instance-form')
	<div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
		<table class="table table-hover table-bordered">
			@foreach ($choices as $choice)
			<tr>
				<td><label class="radio-inline">
					@if (!strcmp($choice->text, $answer))
			    	{!! Form::radio('answer', $choice->id, ['checked']) !!} {{ $choice->text }}
					@else
			    	{!! Form::radio('answer', $choice->id) !!} {{ $choice->text }}
			    	@endif
			    </label></td>
		   	</tr>
		    @endforeach
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