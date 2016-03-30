
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

<div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
	{!! Form::label('body', 'Body:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::textarea('body', null, ['class' => 'form-control']) !!}

		@if ($errors->has('body'))
		    <span class="help-block">
		        <strong>{{ $errors->first('body') }}</strong>
		    </span>
		@endif
	</div>
</div>

<div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
	{!! Form::label('published_at', 'Publish On:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::input('date', 'published_at', $post->published_at, ['class' => 'form-control']) !!}

		@if ($errors->has('published_at'))
	        <span class="help-block">
	            <strong>{{ $errors->first('published_at') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
	{!! Form::label('files', 'Insert files:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::file('files[]', array('multiple'=>true)) !!}

		@if ($errors->has('files'))
		    <span class="help-block">
		        <strong>{{ $errors->first('files') }}</strong>
		    </span>
		@endif
	</div>
</div>

<div class="form-group">
	{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>