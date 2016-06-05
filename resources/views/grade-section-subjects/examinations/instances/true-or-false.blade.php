@extends('grade-section-subjects.examinations.instances.layout')

@section('instance-form')
	@foreach ($questions as $question)
	<div class="panel panel-default">
		<div class="panel-heading">{!! $question->body !!}</div>
	    <table class="table table-responsive">
	    	<tr>
				<td style="width:50%">
    				<label class="radio-inline">
						@if ($answers[$question->id] == '1')
				    	{!! Form::radio('answers[' . $question->id . ']', '1', ['checked']) !!} True
				    	@else
				    	{!! Form::radio('answers[' . $question->id . ']', '1') !!} True
				    	@endif
				    </label>
				</td>
				<td>
    				<label class="radio-inline">
						@if($answers[$question->id] == '0')
				    	{!! Form::radio('answers[' . $question->id . ']', '0', ['checked']) !!} False
						@else					
						{!! Form::radio('answers[' . $question->id . ']', '0') !!} False
				    	@endif
				    </label>
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