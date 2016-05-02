@extends('questions.content.show')

@section('question-details')
<tr>
	<th>Type:</th>
	<td>{{ $question->getQuestionType() }} <span class="glyphicon glyphicon-adjust"></span></td>
</tr>

<tr>
	<th>Right answer:</th>
	<td class="success">
		@if ($rightAnswer)
			True
		@else
			False
		@endif
	</td>
</tr>
@endsection