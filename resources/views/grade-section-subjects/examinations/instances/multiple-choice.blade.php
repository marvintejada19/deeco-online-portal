@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
	@foreach ($questions as $question)
	<div class="panel panel-default">
		<div class="panel-heading">{!! $question->body !!}</div>
	    <table class="table table-responsive">
	    <?php $count = 0; ?>
			<tr>
			@foreach ($choices[$question->id] as $choice)
				<?php 
					if ($count == 3){
						echo "</tr><tr>";
						$count = 0;
					}
				?>
				<td style="width:33%">
					<label class="radio-inline">
					@if (!strcmp($choice->text, $answers[$question->id]))
	    				{!! Form::radio('answers[' . $question->id . ']', $choice->id, ['checked']) !!} {!! $choice->text !!}
					@else
	    				{!! Form::radio('answers[' . $question->id . ']', $choice->id) !!} {!! $choice->text !!}
	    			@endif
	    			</label>
	    		</td>
				<?php $count++; ?>
			@endforeach
			</tr>
		</table>
	</div>
	@endforeach

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			{!! Form::submit('Submit answers', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
@endsection