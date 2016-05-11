
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

<div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
	{!! Form::label('published_at', 'Publish On:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::input('datetime-local', 'published_at', $examination->published_at, ['class' => 'form-control']) !!}

		@if ($errors->has('published_at'))
	        <span class="help-block">
	            <strong>{{ $errors->first('published_at') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<table>
	<tr>
	<td>
		<div class="form-group{{ $errors->has('exam_start') ? ' has-error' : '' }}">
			{!! Form::label('exam_start', 'Available from:', ['class' => 'col-md-4 control-label']) !!}
			<div class="col-md-6">
				{!! Form::input('datetime-local', 'exam_start', $examination->exam_start, ['class' => 'form-control']) !!}
				
				@if ($errors->has('exam_start'))
			        <span class="help-block">
			            <strong>{{ $errors->first('exam_start') }}</strong>
			        </span>
			    @endif
			</div>
		</div>
	</td>
	<td>
		<div class="form-group{{ $errors->has('exam_end') ? ' has-error' : '' }}">
			{!! Form::label('exam_end', 'Available until:', ['class' => 'col-md-4 control-label']) !!}
			<div class="col-md-6">
				{!! Form::input('datetime-local', 'exam_end', $examination->exam_end, ['class' => 'form-control']) !!}
				
				@if ($errors->has('exam_end'))
			        <span class="help-block">
			            <strong>{{ $errors->first('exam_end') }}</strong>
			        </span>
			    @endif
			</div>
		</div>
	</td>
	</tr>
</table>

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