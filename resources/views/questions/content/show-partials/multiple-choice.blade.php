@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-option-horizontal"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">
		{!! $rightAnswer->text !!}
		<a href="{{ $backUrl }}/questions/{{ $question->id }}/multiple-choice/choices/{{ $rightAnswer->id }}/edit" 
			type="submit" class="btn btn-danger btn-xs pull-right">
			Edit
		</a>
	</td>
</tr>

<tr>
	<th>Wrong answers:</th>
	<td>
		<table class="table table-bordered table-responsive">
			@foreach ($wrongAnswers as $wrongAnswer)
			<tr>
				<td>
					{!! $wrongAnswer->text !!}
					<a href="{{ $backUrl }}/questions/{{ $question->id }}/multiple-choice/choices/{{ $wrongAnswer->id }}/edit" 
						type="submit" class="btn btn-danger btn-xs pull-right">
						Edit
					</a>
				</td>
			</tr>
			@endforeach
		</table>
	</td>
</tr>

@endsection