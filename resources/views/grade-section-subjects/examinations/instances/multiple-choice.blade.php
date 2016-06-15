@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
	@foreach ($questions as $question)
	<div class="panel panel-info">
		<div class="panel-heading">{!! $question->body !!}</div>
	    <table class="table table-responsive">
	    	@foreach ($choices[$question->id] as $choice)
	    	<tr>
	    		<td>
					<label class="radio-inline">
					@if (!strcmp($choice->text, $answers[$question->id]))
						{!! Form::radio('answers[' . $question->id . ']', $choice->id, ['checked']) !!} {!! $choice->text !!}
					@else
						{!! Form::radio('answers[' . $question->id . ']', $choice->id) !!} {!! $choice->text !!}
					@endif
					</label>
				</td>
	    	</tr>
	    	@endforeach
		</table>
	</div>
	@endforeach

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			{!! Form::submit('Submit answers', ['class' => 'btn btn-primary form-control']) !!}
		</div>
	</div>
@endsection