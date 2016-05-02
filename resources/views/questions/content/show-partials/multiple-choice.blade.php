@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-option-horizontal"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">{{ $rightAnswer }}</td>
</tr>

<tr>
	<th>Wrong answers:</th>
	<td><ul>
		@foreach ($wrongAnswers as $wrongAnswer)
			<li>{{ $wrongAnswer->text }}</li>
		@endforeach
	</ul></td>
</tr>
@endsection