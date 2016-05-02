@extends('questions.content.create')

@section('type-content')
<div class="form-inline">
	{!! Form::label('format', 'Format:', ['class' => 'col-md-4 control-label']) !!}
    {!! Form::select('format', ['wordbox' => 'Word box', 'columns' => 'Columns'], ['class' => 'form-control']) !!}
    
    <button type="button" class="btn btn-primary btn-sm pull-right" onclick="addItem()">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add another item
    </button><br></br>
</div>

<div class="form-group{{ $errors->has('choices') ? ' has-error' : '' }}">
	{!! Form::label('choices', 'Choices:', ['class' => 'col-md-4 control-label']) !!}
	<div class="col-md-6">
		<div class="control-group">
			{!! Form::text('choices', null, ['id' => 'choices']) !!}

			@if ($errors->has('choices'))
		        <span class="help-block">
		            <strong>{{ $errors->first('choices') }}</strong>
		        </span>
	    	@endif
		</div>
		<script>
		$('#choices').selectize({
			plugins: ['restore_on_backspace', 'remove_button'],
			delimiter: '|',
			persist: false,
			createOnBlur: true,
			create: function(input) {
		        return {
		            value: input,
		            text: input
		        }
		    }
		});
		</script>
		(Please enter all corresponding answers here. You may also put additional choices which have no corresponding item.)
	</div>
</div>

<div class="form-group{{ $errors->has('items') ? ' has-error' : '' }}">
	<div class="col-md-6 form-group well">
		Item: <input type="text" name="items[]" class="form-control" placeholder="Write item here" required>
		Answer: <input type="text" name="answers[]" class="form-control" placeholder="Insert corresponding answer here" required>   
	</div>

	<div class="col-md-6 form-group well">
		Item: <input type="text" name="items[]" class="form-control" placeholder="Write item here" required>
		Answer: <input type="text" name="answers[]" class="form-control" placeholder="Insert corresponding answer here" required>   
	</div>

	<div id="additional_items">
		
	</div>
	
    @if ($errors->has('items'))
        <span class="help-block">
            <strong>{{ $errors->first('items') }}</strong>
        </span>
    @endif
</div>

<script type="text/javascript">
	var count = 0;

	function addItem() {
        var e = document.getElementById('additional_items');
        var newItem = "<div class=\"col-md-6 form-group well\" id=\"div" + count + "\"><button type=\"button\" class=\"btn btn-danger btn-xs pull-right\" onclick=\"removeItem(" + count + ")\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button><br/>Item: <input type=\"text\" name=\"items[]\" id=\"item" + count + "\"class=\"form-control\" placeholder=\"Write item here\" required>Answer: <input type=\"text\" name=\"answers[]\" id=\"answer" + count + "\" class=\"form-control\" placeholder=\"Insert corresponding answer here\" required></div>";
        e.innerHTML = e.innerHTML + newItem;
        count++;
	}

	function removeItem(id){
		document.getElementById("item" + id).name = '';
    	document.getElementById("item" + id).disabled = 'true';	
    	document.getElementById("answer" + id).name = '';
    	document.getElementById("answer" + id).disabled = 'true';	
    	document.getElementById("div" + id).style.display = 'none';
	}
</script>
@endsection