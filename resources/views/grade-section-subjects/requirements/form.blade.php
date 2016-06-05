
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
	{!! Form::label('title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}

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

<div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
	{!! Form::label('files',  $filesButtonText . ' (Optional)', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::file('files[]', ['multiple'=>true]) !!}

		@if ($errors->has('files'))
		    <span class="help-block">
		        <strong>{{ $errors->first('files') }}</strong>
		    </span>
		@endif
		<h5><font color='red'>* 16mb file size limit</font></h5>

		@if (count($requirement->files))
			{!! Form::label('', 'Please uncheck if you wish to remove file', ['class' => 'col-md-4 control-label']) !!}
			<br/>
			@foreach ($requirement->files as $file)
				{!! Form::checkbox('old_files[]', $file->id, true) !!} {{ $file->file_name }}<br/>
			@endforeach
		@endif
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/requirements'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>