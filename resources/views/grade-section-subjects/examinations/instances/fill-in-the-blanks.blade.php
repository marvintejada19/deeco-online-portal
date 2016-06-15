@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
	@foreach ($questions as $question)
	<div class="panel panel-info">
		<div class="panel-heading">{!! $question->body !!}</div>
	    <table class="table table-responsive">
	    	<tr>
				<td style="width:100%">
    				{!! Form::text('answers[' . $question->id . ']', $answers[$question->id], ['class' => 'form-control', 'required']) !!}
				</td>
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