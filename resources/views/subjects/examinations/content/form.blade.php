<div class="form-group{{ $errors->has('subcategory') ? ' has-error' : '' }}">
    {!! Form::label('subcategory', 'Subcategory', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('subcategory', $subcategories, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...']) !!}

        @if ($errors->has('subcategory'))
            <span class="help-block">
                <strong>{{ $errors->first('subcategory') }}</strong>
            </span>
        @endif
    </div>
</div>


<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
	{!! Form::label('description', 'Description:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('description', null, ['class' => 'form-control']) !!}

		@if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
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

<div class="form-inline">
	<div class="form-group{{ $errors->has('exam_start') ? ' has-error' : '' }}">
		{!! Form::label('exam_start', 'Available to students from:', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-6">
			{!! Form::input('datetime-local', 'exam_start', $examination->exam_start, ['class' => 'form-control']) !!}
			
			@if ($errors->has('exam_start'))
		        <span class="help-block">
		            <strong>{{ $errors->first('exam_start') }}</strong>
		        </span>
		    @endif
		</div>
	</div>
	<div class="form-group{{ $errors->has('exam_end') ? ' has-error' : '' }}">
		{!! Form::label('exam_end', 'Available to students until:', ['class' => 'col-md-4 control-label']) !!}
		<div class="col-md-6">
			{!! Form::input('datetime-local', 'exam_end', $examination->exam_end, ['class' => 'form-control']) !!}
			
			@if ($errors->has('exam_end'))
		        <span class="help-block">
		            <strong>{{ $errors->first('exam_end') }}</strong>
		        </span>
		    @endif
		</div>
	</div>
	<br></br>	
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