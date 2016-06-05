<div class="form-group">
    {!! Form::label('subcategory', 'Subcategory', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('subcategory', $subcategories, null, ['class' => 'form-control', 'placeholder' => 'Select from the following...', 'required']) !!}
    </div>
</div>


<div class="form-group">
	{!! Form::label('description', 'Description:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		{!! Form::text('description', null, ['class' => 'form-control', 'required', 'maxlength' => '255']) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label('quarter', 'Quarter', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    	{!! Form::number('quarter', (isset($examination->quarter) ? $examination->quarter : 1), ['min' => '1', 'max' => '4', 'class' => 'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		<button type="button" class="btn btn-danger" onclick="location.href='/examinations'">
			Back
		</button>
	</div>
</div>

<div class="form-group pull-right">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
	</div>
</div>