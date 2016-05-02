<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	{!! Form::label('name', 'Name:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('name', null, ['class' => 'form-control']) !!}

		@if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/categories'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>