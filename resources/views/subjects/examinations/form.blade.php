
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
	{!! Form::label('title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('title', null, ['class' => 'form-control']) !!}

		@if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/subjects/{{ $subject->id }}/examinations'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>