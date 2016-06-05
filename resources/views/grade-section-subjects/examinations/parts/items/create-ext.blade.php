<div class="form-group">
    {!! Form::label('question_subtopic_id', 'Subtopic', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
		<select name="question_subtopic_id" id="subtopic_ddl" onchange="configureSubtopicDropDownLists()" class="form-control" required>
			<option value="" disabled selected>Select from the following...</option>
			@foreach ($subtopics as $key => $name)
				<option value="{{ $key }}">{{ $name }}</option>
			@endforeach
		</select>
    </div>
</div>

<div class="form-group">
    {!! Form::label('question_id', 'Question', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
		<select name="question_id" id="question_ddl" class="form-control" required>
			<option value="" disabled selected>Select from the following...</option>
		</select>
    </div>
</div>

@if (!strcmp($part->getQuestionType(), 'Match Column A with Column B'))
<div class="form-group">
    {!! Form::label('choices_quantity', 'No. of wrong choices:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('choices_quantity', 0, ['min' => '0', 'class' => 'form-control', 'required']) !!}
    </div>
</div>
@endif

<script type="text/javascript">
	function configureSubtopicDropDownLists() {
		ddl1 = document.getElementById('subtopic_ddl');
		ddl2 = document.getElementById('question_ddl');
		switch (ddl1.value) {
	    	<?php 
			foreach ($subtopics as $key => $name){
				echo "case '" . $key . "': " .
						"ddl2.options.length = 0; " .
						"var opt0 = document.createElement('option'); " .
						"opt0.value = ''; " . 
						"opt0.text = 'Select from the following...'; " .
						"ddl2.options.add(opt0); ";
				foreach ($questions[$key] as $question){
				echo 	"var opt = document.createElement('option'); " .
						"opt.value = '" . $question->id . "'; " .
						"opt.text = '" . $question->title . "'; " .
						"ddl2.options.add(opt);";
				}
				echo 	"break;";
			}
	    	?>
	    	default:
	    		ddl2.options.length = 0;
	    }
	}
</script>